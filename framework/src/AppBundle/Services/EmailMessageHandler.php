<?php

namespace AppBundle\Services;

use AppBundle\Entity\EmailMessage;
use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityManager;
use Message\Message\EmailMessageHandler as BaseEmailMessageHandler;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageInterface;
use Message\Message\MessageReceiverInterface;
use Message\Message\ScheduledMessageInterface;

/**
 * Class EmailMessageHandler
 *
 * @package framework\src\AppBundle\Services
 */
class EmailMessageHandler extends BaseEmailMessageHandler
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * EmailMessageHandler constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param EntityManager $em
     */
    public function __construct(\Swift_Mailer $mailer, EntityManager $em)
    {
        $this->mailer = $mailer;
        $this->em = $em;
    }

    /**
     * @inheritdoc
     */
    public function store(CustomerInterface $customer, MessageInterface $message, Array $data)
    {
        $emailMessage = new EmailMessage();
        $emailMessage->setAbout($data['about']);
        $emailMessage->setFromAddress($data['from']);
        $emailMessage->setMessage($message);
        $emailMessage->setCustomer($customer);
        return $emailMessage;
    }

    /**
     * @inheritdoc
     */
    public function deliver(MessageInterface $message,
                            MessageReceiverInterface $messageReceiver,
                            MessageDependantInterface $messageDependant,
                            ScheduledMessageInterface $scheduledMessage)
    {
        return true;
    }
}