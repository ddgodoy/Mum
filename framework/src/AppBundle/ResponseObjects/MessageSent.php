<?php

namespace AppBundle\ResponseObjects;
use Message\Message\MessageInterface;

/**
 * Class MessageSent
 *
 * @package AppBundle\ResponseObjects
 */
class MessageSent
{
    /**
     * @var string
     */
    public $message;

    /**
     * MessageSent constructor.
     *
     * @param MessageInterface $message
     */
    public function __construct(MessageInterface $message)
    {
        $this->message = $message->getId();
    }
}