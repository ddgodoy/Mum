<?php

namespace AppBundle\Services;

use AppBundle\Entity\SMSMessage;
use Customer\Customer\CustomerInterface;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageHandler;
use Message\Message\MessageInterface;
use Message\Message\MessageReceiverInterface;
use Scheduler\Scheduler\ScheduledMessageInterface;

/**
 * Class SMSMessageHandler
 *
 * @package AppBundle\Services
 */
class SMSMessageHandler extends MessageHandler
{

    /**
     * @var Twilio
     */
    private $twilio;

    /**
     * SMSMessageHandler constructor.
     *
     * @param Twilio $twilio
     */
    public function __construct(Twilio $twilio)
    {
        $this->twilio = $twilio;
    }

    /**
     * @inheritdoc
     */
    public function store(CustomerInterface $customer, MessageInterface $message, Array $data)
    {
        $smsMessage = new SMSMessage();
        $smsMessage->setMessage($message);
        $smsMessage->setCustomer($customer);
        return $smsMessage;
    }

    /**
     * @inheritdoc
     */
    public function deliver(MessageInterface $message,
                            MessageReceiverInterface $messageReceiver,
                            MessageDependantInterface $messageDependant,
                            ScheduledMessageInterface $scheduledMessage = null)
    {
        $message = sprintf($message->getBody());

        foreach ($messageReceiver->getReceivers() as $receiver) {
            $to = sprintf('+%s', $receiver);
            $this->twilio->sendToNumber($message, $to);
        }

        return true;
    }
}