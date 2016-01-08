<?php

namespace Message\Email;

use Customer\Customer\CustomerInterface;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageHandlerInterface;
use Message\Message\MessageInterface;
use Message\Message\MessageReceiverInterface;
use Scheduler\Scheduler\ScheduledMessageInterface;

/**
 * Class EmailMessageHandler
 *
 * @package Message\Email
 */
class EmailMessageHandler implements MessageHandlerInterface
{

    /**
     * @inheritdoc
     */
    public function store(CustomerInterface $customer, MessageInterface $message, Array $data)
    {
    }

    /**
     * @inheritdoc
     */
    public function preDeliver(MessageInterface $message,
                               MessageReceiverInterface $messageReceiver,
                               MessageDependantInterface $messageDependant,
                               ScheduledMessageInterface $scheduledMessage = null)
    {
        if ($scheduledMessage) {
            $scheduledMessage->nextStatus();
        }
    }

    /**
     * @inheritdoc
     */
    public function deliver(MessageInterface $message,
                            MessageReceiverInterface $messageReceiver,
                            MessageDependantInterface $messageDependant,
                            ScheduledMessageInterface $scheduledMessage = null)
    {
    }

    /**
     * @inheritdoc
     */
    public function postDeliver(MessageInterface $message,
                                MessageReceiverInterface $messageReceiver,
                                MessageDependantInterface $messageDependant,
                                ScheduledMessageInterface $scheduledMessage = null)
    {
        if ($scheduledMessage) {
            $scheduledMessage->nextStatus();
        }
    }
}