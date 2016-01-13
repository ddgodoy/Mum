<?php

namespace AppBundle\Services;

use AppBundle\Entity\InstantMessage;
use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityManager;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageHandler;
use Message\Message\MessageInterface;
use Message\Message\MessageReceiverInterface;
use Scheduler\Scheduler\ScheduledMessageInterface;

/**
 * Class InstantMessageHandler
 *
 * @package AppBundle\Services
 */
class InstantMessageHandler extends MessageHandler
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
        $instantMessage = new InstantMessage();
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
        return true;
    }
}