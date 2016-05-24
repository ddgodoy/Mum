<?php

namespace AppBundle\ResponseObjects;

/**
 * Class Messages
 *
 * @package AppBundle\ResponseObjects
 */
class Messages
{

    /**
     * @var array
     */
    public $messages;

    /**
     * Messages constructor.
     * 
     * @param array $messages
     */
    public function __construct(array $messages)
    {
        $this->messages = $messages;
    }
}