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
    public $sent;

    /**
     * MessageSent constructor.
     *
     * @param MessageInterface $message
     * @param boolean $sent
     */
    public function __construct(MessageInterface $message, $sent)
    {
        $this->message = $message->getId();
        $this->sent = $sent;
    }
}