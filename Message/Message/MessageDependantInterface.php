<?php

namespace Message\Message;

/**
 * Interface MessageTypeInterface
 *
 * @package Message\Message
 */
interface MessageDependantInterface
{
    /**
     * Set the Message Receiver Message relation
     *
     * @param MessageInterface $message
     */
    public function setMessage(MessageInterface $message);

    /**
     * Get the Message Receiver Message relation
     *
     * @return MessageInterface
     */
    public function getMessage();
}