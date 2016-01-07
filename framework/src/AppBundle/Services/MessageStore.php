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
    private $em;

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
        $objects = $this->storeMessage($customer, $body, $at, $receivers);
        $message = $objects['message'];

        // create email message

        $this->em->persist($emailMessage);

        // execute
        $this->em->flush();

        $objects['messageDependant'] = $emailMessage;

        return $objects;
    }
}