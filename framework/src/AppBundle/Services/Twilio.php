<?php

namespace AppBundle\Services;

use Vresh\TwilioBundle\Service\TwilioWrapper;

/**
 * Class Twilio
 *
 * @package AppBundle\Services
 */
class Twilio
{
    /**
     * @var TwilioWrapper
     */
    private $twilio;

    /**
     * @var string
     */
    private $sendNumber;

    /**
     * Twilio constructor.
     * @param TwilioWrapper $twilio
     * @param string $sendNumber
     */
    public function __construct(TwilioWrapper $twilio, $sendNumber)
    {
        $this->twilio = $twilio;
        $this->sendNumber = $sendNumber;
    }

    /**
     * Send a new twilio message
     *
     * @param $message
     * @param $to
     * @return mixed
     */
    public function sendToNumber($message, $to)
    {
        $messages = $this->twilio->account->messages;
        $message = $messages->sendMessage($this->sendNumber, $to, $message);

        return $message->sid;
    }
}