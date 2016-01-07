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
     * @var boolean
     */
    public $delivered;

    /**
     * MessageSent constructor.
     *
     * @param MessageInterface $message
     * @param boolean $delivered
     */
    public function __construct(MessageInterface $message, $delivered)
    {
        $this->message = $message->getId();
        $this->delivered = $delivered;
    }
}