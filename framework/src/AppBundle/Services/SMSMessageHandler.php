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
     * @var EntityManager
     */
    private $em;

    /**
     * EmailMessageHandler constructor.
     *
     * @param $dummy
     * @param EntityManager $em
     */
    public function __construct($dummy, EntityManager $em)
    {
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
        return true;
    }
}