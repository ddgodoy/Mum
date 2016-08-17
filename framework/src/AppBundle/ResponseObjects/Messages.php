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
        $response = [];
        for ($i = 0; $i < count($messages); $i += 2) {
            $response[] = [
                "customer" => $messages[$i]->getCustomer(),
                "room" => $messages[$i]->getRoom(),
                "message" => $messages[$i]->getMessage(),
                "receivers" => $messages[$i + 1]->getReceivers(),
                "received" => $messages[$i + 1]->getReceived(),
                "attachment" => ($messages[$i]->getMessage()->getAttachment())? $messages[$i]->getMessage()->getAttachment() : false
            ];
        }
        $this->messages = $response;
    }
}