<?php

namespace AppBundle\Services;

use AppBundle\Entity\Message;
use AppBundle\Entity\MessageReceiver;
use AppBundle\Entity\ScheduledMessage;
use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityManager;
use Message\Message\MessageHandlerInterface;
use Scheduler\Scheduler\MessageDispatcher as BaseMessageDispatcher;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MessageDispatcher
 *
 * @package AppBundle\Services
 */
class MessageDispatcher extends BaseMessageDispatcher
{

    /**
     * @var Array
     */
    private $messageTypes;

    /**
     * @var ContainerInterface
     */
    private $serviceContainer;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * MessageDispatcher constructor.
     *
     * @param array messageTypes
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(Array $messageTypes, ContainerInterface $serviceContainer)
    {
        $this->messageTypes = $messageTypes;
        $this->serviceContainer = $serviceContainer;
        $this->em = $this->serviceContainer->get('doctrine.orm.entity_manager');
    }

    /**
     * Store the message
     *
     * @param CustomerInterface $customer
     * @param MessageHandlerInterface $messageDependantHandler
     * @param array $data
     * @return array
     */
    public function store(CustomerInterface $customer, MessageHandlerInterface $messageDependantHandler, Array $data)
    {
        // create message
        $message = new Message();
        $message->setBody($data['message']['body']);
        $message->setCustomer($customer);

        // create message receiver
        $messageReceiver = new MessageReceiver();
        $messageReceiver->setReceivers($data['message']['receivers']);
        $messageReceiver->setMessage($message);
        $messageReceiver->setCustomer($customer);

        $scheduledMessage = null;
        // if at is specified create scheduled message
        if ($data['message']['at']) {
            $scheduledMessage = new ScheduledMessage();
            $scheduledMessage->setAt($data['message']['at']);
            $scheduledMessage->setMessage($message);
            $scheduledMessage->setCustomer($customer);
        }

        $messageDependant = $messageDependantHandler->store($customer, $message, $data);

        return [
            'message' => $message,
            'messageReceivers' => $messageReceiver,
            'scheduledMessage' => $scheduledMessage,
            'messageDependant' => $messageDependant
        ];
    }

    /**
     * Get the Specific Message Handler
     *
     * @param $serviceHandlerName
     * @return object
     */
    private function getMessageHandler($serviceHandlerName)
    {
        return $this->serviceContainer->get('mum.message.handler.' . strtolower($serviceHandlerName));
    }

    /**
     * Handle new Message
     *
     * @param CustomerInterface $customer
     * @param array $data
     * @param string $serviceHandlerName
     * @return array
     * @throws \Exception
     */
    public function handleMessage(CustomerInterface $customer, Array $data, $serviceHandlerName)
    {
        if (!in_array($serviceHandlerName, $this->messageTypes)) {
            throw new \Exception('Message Type not available');
        }

        // get the specific message handler
        $messageDependantHandler = $this->getMessageHandler($serviceHandlerName);
        // store the message
        $objects = $this->store($customer, $messageDependantHandler, $data);
        // deliver the message
        $delivered = $this->deliver($objects['message'],
            $objects['messageReceivers'],
            $objects['messageDependant'],
            $objects['scheduledMessage'],
            $messageDependantHandler);
        // save all changes
        $this->em->persist($objects['message']);
        $this->em->persist($objects['messageReceivers']);
        $this->em->persist($objects['messageDependant']);
        if ($objects['scheduledMessage']) {
            $this->em->persist($objects['scheduledMessage']);
        }
        $this->em->flush();
        return [
            'message' => $objects['message'],
            'delivered' => $delivered
        ];
    }

    /**
     * Dispatch all messages that pass the deadline
     *
     * @return array
     */
    public function dispatch()
    {
        $stats = [];
        foreach ($this->messageTypes as $messageType) {
            $stats[$messageType] = 0;
            // get the specific message handler
            $messageDependantHandler = $this->getMessageHandler($messageType);

            // compute the query and get results
            $messageDependantRepository = $this->em->getRepository('AppBundle:' . $messageType . 'Message');
            $from = $messageDependantRepository->getFrom();
            $where = $messageDependantRepository->getWhere();
            $scheduledMessages = $this->em->getRepository('AppBundle:ScheduledMessage')->findDeliveryReady($from, $where);

            for ($i = 0; $i < count($scheduledMessages); $i += 4) {
                // deliver the message
                $delivered = $this->deliver($scheduledMessages[$i + 1],
                    $scheduledMessages[$i + 2],
                    $scheduledMessages[$i + 3],
                    $scheduledMessages[$i],
                    $messageDependantHandler);
                if ($delivered) {
                    $stats[$messageType] += 1;
                }
            }
        }
        $this->em->flush();
        return $stats;
    }
}