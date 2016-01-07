<?php

namespace Message\Message;

use Customer\Customer\CustomerInterface;

/**
 * Class EmailMessageHandler
 *
 * @package Message\Message
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
                               ScheduledMessageInterface $scheduledMessage)
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
                            ScheduledMessageInterface $scheduledMessage)
    {
    }

    /**
     * @inheritdoc
     */
    public function postDeliver(MessageInterface $message,
                                MessageReceiverInterface $messageReceiver,
                                MessageDependantInterface $messageDependant,
                                ScheduledMessageInterface $scheduledMessage)
    {
        if ($scheduledMessage) {
            $scheduledMessage->nextStatus();
        }
    }
}