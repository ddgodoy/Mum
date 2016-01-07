<?php

namespace AppBundle\Services;

use AppBundle\Entity\EmailMessage;
use AppBundle\Entity\Message;
use AppBundle\Entity\MessageReceiver;
use AppBundle\Entity\ScheduledMessage;
use Customer\Customer\CustomerInterface;
use Doctrine\ORM\EntityManager;

/**
 * Class MessageStore
 *
 * @package AppBundle\Services
 */
class MessageStore
{

    /**
     * @var EntityManager
     */
    public $em;

    /**
     * MessageStore constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em)
    {
        $this->em = $em;
    }

    /**
     * Store new Message
     *
     * @param CustomerInterface $customer
     * @param string $body
     * @param \DateTime $at
     * @param array $receivers
     * @return Message
     */
    private function storeMessage(CustomerInterface $customer, $body, \DateTime $at, Array $receivers)
    {
        // create message
        $message = new Message();
        $message->setBody($body);
        $message->setCustomer($customer);
        $this->em->persist($message);

        // create message receiver
        $messageReceiver = new MessageReceiver();
        $messageReceiver->setReceivers($receivers);
        $messageReceiver->setMessage($message);
        $messageReceiver->setCustomer($customer);
        $this->em->persist($messageReceiver);

        // if when is specified
        if ($at) {
            // create scheduled message
            $scheduledMessage = new ScheduledMessage();
            $scheduledMessage->setAt($at);
            $scheduledMessage->setMessage($message);
            $scheduledMessage->setCustomer($customer);
            $this->em->persist($scheduledMessage);
        }

        return $message;
    }

    /**
     * Store new Email Message
     *
     * @param CustomerInterface $customer
     * @param string $body
     * @param \DateTime $at
     * @param array $receivers
     * @param string $about
     * @param string $from
     * @return Message
     */
    public function storeEmailMessage(CustomerInterface $customer, $body, \DateTime $at, Array $receivers, $about, $from)
    {
        $message = $this->storeMessage($customer, $body, $at, $receivers);

        // create email message
        $emailMessage = new EmailMessage();
        $emailMessage->setAbout($about);
        $emailMessage->setFromAddress($from);
        $emailMessage->setMessage($message);
        $emailMessage->setCustomer($customer);
        $this->em->persist($emailMessage);

        // execute
        $this->em->flush();

        return $message;
    }
}