<?php

namespace Message\Message;

/**
 * Class MessageDispatcher
 *
 * @package Message\Message
 */
class MessageDispatcher
{
    /**
     * Checks if the message needs to be deliver now
     *
     * @param ScheduledMessageInterface $scheduledMessage
     * @return bool
     */
    private function needsToBeDeliver(ScheduledMessageInterface $scheduledMessage)
    {
        return $scheduledMessage &&
        $scheduledMessage->getStatus() === (new ScheduledMessageStatusCreated())->getId() &&
        $scheduledMessage->getAt() < new \DateTime();
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
                               ScheduledMessageInterface $scheduledMessage,
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