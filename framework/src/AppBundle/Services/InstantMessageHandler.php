<?php

namespace AppBundle\Services;

use AppBundle\Entity\InstantMessage;
use AppBundle\Entity\Room;
use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityManager;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageHandler;
use Message\Message\MessageInterface;
use Message\Message\MessageReceiverInterface;
use Monolog\Logger;
use Scheduler\Scheduler\ScheduledMessageInterface;

/**
 * Class InstantMessageHandler
 *
 * @package AppBundle\Services
 */
class InstantMessageHandler extends MessageHandler
{

    /**
     * @var array
     */
    private $pushNotificationServices = array();

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * EmailMessageHandler constructor.
     *
     * @param array $pushNotificationServices
     * @param EntityManager $em
     * @param Logger $logger
     */
    public function __construct(array $pushNotificationServices, EntityManager $em, Logger $logger)
    {
        $this->pushNotificationServices = $pushNotificationServices;
        $this->em = $em;
        $this->logger = $logger;
    }

    /**
     * @inheritdoc
     */
    public function store(CustomerInterface $customer, MessageInterface &$message, Array $data)
    {
        $room = $this->em->getRepository("AppBundle:Room")->find($data["room"]);

        if (!$room) {
            $room = new Room($data["room"]);
            $this->em->persist($room);
        }

        $instantMessage = new InstantMessage($room);
        $instantMessage->setMessage($message);
        $instantMessage->setCustomer($customer);
        return $instantMessage;
    }

    /**
     * @inheritdoc
     */
    public function deliver(MessageInterface $message,
                            MessageReceiverInterface $messageReceiver,
                            MessageDependantInterface $messageDependant,
                            ScheduledMessageInterface $scheduledMessage = null)
    {
        $receivers = $messageReceiver->getReceivers();
        foreach ($receivers as $receiver) {
            $devices = $this->em->getRepository('AppBundle:Device')
                ->getByCustomer($receiver);
            if (count($devices)) {
                foreach ($devices as $device) {
                    if ($device && array_key_exists($device->getOS(), $this->pushNotificationServices)) {
                        $extra = ['type' => 2];
                        $extra['messageId'] = $message->getId();
                        $extra['receivers'] = $receivers;
                        $extra['sender'] = $message->getCustomer()->getUsername();
                        $title = sprintf('New Mum from %s', $message->getCustomer()->getUsername());
                        $body = $message->getBody();

                        $stats = $this->pushNotificationServices[$device->getOS()]->sendNotification(
                            [$device->getId()],
                            $title,
                            $body,
                            $extra,
                            null);

                        $delivered = !($stats['successful'] <= 0);
                        $logMessage = sprintf("Instant Message sent to %s: %s",
                            $device->getId(),
                            $delivered ? "true" : "false");
                        $this->logger->debug($logMessage);
                    }
                }
            } else {
                $this->logger->debug("Instant Message don't delivered since 0 registered device");

                return false;
            }

            return true;
        }
    }
}