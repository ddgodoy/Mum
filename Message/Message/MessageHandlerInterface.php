<?php

namespace Message\Message;

use Customer\Customer\CustomerInterface;

interface MessageHandlerInterface
{
    /**
     * Store a Message dependant
     *
     * @param CustomerInterface $customer
     * @param MessageInterface $message
     * @param array $data
     * @return MessageDependantInterface
     */
    public function store(CustomerInterface $customer, MessageInterface $message, Array $data);

    /**
     * Pre Deliver the Message
     *
     * @param MessageInterface $message
     * @param MessageReceiverInterface $messageReceiver
     * @param MessageDependantInterface $messageDependant
     * @param ScheduledMessageInterface $scheduledMessage
     */
    public function preDeliver(MessageInterface $message,
                               MessageReceiverInterface $messageReceiver,
                               MessageDependantInterface $messageDependant,
                               ScheduledMessageInterface $scheduledMessage);

    /**
     * Deliver the Message
     *
     * @param MessageInterface $message
     * @param MessageReceiverInterface $messageReceiver
     * @param MessageDependantInterface $messageDependant
     * @param ScheduledMessageInterface $scheduledMessage
     * @return boolean
     */
    public function deliver(MessageInterface $message,
                            MessageReceiverInterface $messageReceiver,
                            MessageDependantInterface $messageDependant,
                            ScheduledMessageInterface $scheduledMessage);

    /**
     * Post Deliver the Message
     *
     * @param MessageInterface $message
     * @param MessageReceiverInterface $messageReceiver
     * @param MessageDependantInterface $messageDependant
     * @param ScheduledMessageInterface $scheduledMessage
     */
    public function postDeliver(MessageInterface $message,
                                MessageReceiverInterface $messageReceiver,
                                MessageDependantInterface $messageDependant,
                                ScheduledMessageInterface $scheduledMessage);
}