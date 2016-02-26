<?php

namespace AppBundle\Services;

use AppBundle\Entity\SMSMessage;
use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityManager;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageHandler;
use Message\Message\MessageInterface;
use Message\Message\MessageReceiverInterface;
use Scheduler\Scheduler\ScheduledMessageInterface;

/**
 * Class SMSMessageHandler
 *
 * @package AppBundle\Services
 */
class SMSMessageHandler extends MessageHandler
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
     * EmailMessageHandler constructor.
     *
     * @param array $pushNotificationServices
     * @param EntityManager $em
     */
    public function __construct(array $pushNotificationServices, EntityManager $em)
    {
        $this->pushNotificationServices = $pushNotificationServices;
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function store(CustomerInterface $customer, MessageInterface $message, Array $data)
    {
        $smsMessage = new SMSMessage();
        $smsMessage->setMessage($message);
        $smsMessage->setCustomer($customer);
        return $smsMessage;
    }

    /**
     * @inheritdoc
     */
    public function deliver(MessageInterface $message,
                            MessageReceiverInterface $messageReceiver,
                            MessageDependantInterface $messageDependant,
                            ScheduledMessageInterface $scheduledMessage = null)
    {
        $device = $this->em->getRepository('AppBundle:Device')
            ->findOneBy(['customer' => $message->getCustomer()->getId()]);
        if ($device && array_key_exists($device->getOS(), $this->pushNotificationServices)) {

            $extra = ['type' => 1];
            $extra["smsBody"] = $message->getBody();
            $extra["receivers"] = $messageReceiver->getReceivers();

            $stats = $this->pushNotificationServices[$device->getOS()]->sendNotification(
                [$device->getId()],
                null,
                null,
                $extra,
                null);

            return $stats['successful'] > 0;
        }

        return false;
    }
}