<?php

namespace Scheduler\Scheduler;

use Message\Message\MessageDependantInterface;
use Message\Message\MessageHandlerInterface;
use Message\Message\MessageInterface;
use Message\Message\MessageReceiverInterface;

/**
 * Class MessageDispatcher
 *
 * @package Scheduler\Scheduler
 */
class MessageDispatcher
{
    /**
     * Checks if the message needs to be deliver now
     *
     * @param ScheduledMessageInterface $scheduledMessage
     * @return bool
     */
    private function needsToBeDeliver(ScheduledMessageInterface $scheduledMessage = null)
    {
        return !$scheduledMessage || ($scheduledMessage &&
            $scheduledMessage->getStatus() === (new ScheduledMessageStatusCreated())->getId() &&
            $scheduledMessage->getAt() < new \DateTime());
    }

    /**
     * Delivers the message
     *
     * @param MessageInterface $message
     * @param MessageReceiverInterface $messageReceiver
     * @param MessageDependantInterface $messageDependant
     * @param ScheduledMessageInterface $scheduledMessage
     * @param MessageHandlerInterface $messageHandler
     * @return boolean
     */
    protected function deliver(MessageInterface $message,
                               MessageReceiverInterface $messageReceiver,
                               MessageDependantInterface $messageDependant,
                               ScheduledMessageInterface $scheduledMessage = null,
                               MessageHandlerInterface $messageHandler)
    {
        if ($this->needsToBeDeliver($scheduledMessage)) {
            $messageHandler->preDeliver($message, $messageReceiver, $messageDependant, $scheduledMessage);
            $delivered = $messageHandler->deliver($message, $messageReceiver, $messageDependant, $scheduledMessage);
            if ($delivered) {
                $messageHandler->postDeliver($message, $messageReceiver, $messageDependant, $scheduledMessage);
            }
            return $delivered;
        }

        return false;
    }
}