<?php

namespace AppBundle\Services;

use AppBundle\Entity\Message;
use AppBundle\Entity\MessageReceiver;
use AppBundle\Entity\ScheduledMessage;
use Customer\Customer\CustomerInterface;
use Message\Message\MessageDispatcher as BaseMessageDispatcher;
use Message\Message\MessageHandlerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class MessageDispatcher
 *
 * @package AppBundle\Services
 */
class MessageDispatcher extends BaseMessageDispatcher
{

    /**
     * @var ContainerInterface
     */
    private $serviceContainer;

    /**
     * MessageDispatcher constructor.
     *
     * @param ContainerInterface $serviceContainer
     */
    public function __construct(ContainerInterface $serviceContainer)
    {
        $this->serviceContainer = $serviceContainer;
    }

    /**
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
     * Handle new Message
     *
     * @param CustomerInterface $customer
     * @param array $data
     * @param string $serviceHandlerName
     * @return array
     */
    public function handleMessage(CustomerInterface $customer, Array $data, $serviceHandlerName)
    {
        // store the message
        $messageDependantHandler = $this->serviceContainer->get('mum.message.handler.' . $serviceHandlerName);
        $objects = $this->store($customer, $messageDependantHandler, $data);
        $em = $this->serviceContainer->get('doctrine.orm.entity_manager');
        // deliver the message
        $delivered = $this->deliver($objects['message'],
            $objects['messageReceivers'],
            $objects['messageDependant'],
            $objects['scheduledMessage'],
            $messageDependantHandler);
        // save all changes
        $em->persist($objects['message']);
        $em->persist($objects['messageReceivers']);
        $em->persist($objects['scheduledMessage']);
        $em->persist($objects['messageDependant']);
        $em->flush();
        return [
            'message' => $objects['message'],
            'delivered' => $delivered
        ];
    }
}