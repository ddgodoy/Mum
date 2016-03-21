<?php

namespace AppBundle\Services;

use AppBundle\Entity\EmailMessage;
use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityManager;
use Message\Message\MessageDependantInterface;
use Message\Message\MessageHandler;
use Message\Message\MessageInterface;
use Message\Message\MessageReceiverInterface;
use Monolog\Logger;
use Scheduler\Scheduler\ScheduledMessageInterface;

/**
 * Class EmailMessageHandler
 *
 * @package AppBundle\Services
 */
class EmailMessageHandler extends MessageHandler
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
     * @var Logger
     */
    private $logger;

    /**
     * EmailMessageHandler constructor.
     *
     * @param \Swift_Mailer $mailer
     * @param EntityManager $em
     * @param Logger $logger
     */
    public function __construct(\Swift_Mailer $mailer, EntityManager $em, Logger $logger)
    {
        $this->mailer = $mailer;
        $this->em = $em;
        $this->logger = $logger;
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
                            ScheduledMessageInterface $scheduledMessage = null)
    {
        $swiftMessage = \Swift_Message::newInstance()
            ->setSubject($messageDependant->getAbout())
            ->setFrom($messageDependant->getFromAddress())
            ->setSender($messageDependant->getFromAddress())
            ->setReplyTo($messageDependant->getFromAddress())
            ->setBody($message->getBody(), 'text/html')
            ->setBody($message->getBody(), 'text/plain');

        foreach ($messageReceiver->getReceivers() as $receiver) {
            $swiftMessage->addTo($receiver);
        }

        $response = $this->mailer->send($swiftMessage);
        $this->logger->debug(sprintf("Email sent to %s: %s", join(", ", $messageReceiver->getReceivers()), $response !== 0 ? "true" : "false"));

        return $response !== 0;
    }
}