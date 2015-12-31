<?php

namespace AppBundle\Services;

use AppBundle\Entity\Customer;
use AppBundle\Entity\RegistrationAttempt;
use Customer\Customer\CustomerInterface;
use Customer\Registration\RegistrationAttemptInterface;
use Customer\Registration\RegistrationHandler;
use Doctrine\ORM\EntityManager;

/**
 * Class CustomerRegistration
 *
 * @package framework\src\AppBundle\Services
 */
class CustomerRegistration
{
    /**
     * @var Twilio
     */
    public $twilio;

    public $em;

    /**
     * CustomerRegistration constructor.
     * @param Twilio $twilio
     * @param EntityManager $em
     */
    public function __construct(Twilio $twilio, EntityManager $em)
    {
        $this->twilio = $twilio;
        $this->em = $em;
    }

    /**
     * Register new customer
     *
     * @param CustomerInterface $customer
     * @return Customer
     */
    public function register(CustomerInterface $customer)
    {
        // perform business registration
        $registrationAttempt = new RegistrationAttempt();
        $handler = new RegistrationHandler();
        $handler->register($customer, $registrationAttempt);

        // send confirmation token by sms
        $attempts = $customer->getRegistrationAttempts();
        $attempt = $attempts[count($attempts) - 1];
        $message = sprintf('Your confirmation number is %s', $attempt->getToken());
        $to = sprintf('+%s', $customer->getUsername());
        $messageId = $this->twilio->sendToNumber($message, $to);
        $attempt->setSMSId($messageId);
        $attempt->setCustomer($customer);
        $registrationAttempt->nextStatus();

        // store
        $customers = $this->em->getRepository('AppBundle:Customer')->findByUsername($customer->getUsername());
        // if the user is already registered just register the attempt
        if (count($customers)) {
            $customer = $customers[0];
            $attempt->setCustomer($customer);
            $this->em->persist($attempt);
            $this->em->flush();
        } // otherwise register the whole customer attempt relation
        else {
            $this->em->persist($customer);
            $this->em->flush();
        }

        return $attempt;
    }

    /**
     * Confirm the customer by its attempt
     *
     * @param CustomerInterface $customer
     * @param RegistrationAttemptInterface $registrationAttempt
     * @return mixed|false
     */
    public function confirm(CustomerInterface $customer, RegistrationAttemptInterface $registrationAttempt)
    {
        $handler = new RegistrationHandler();
        $response = $handler->confirm($customer, $registrationAttempt);
        if (!is_array($response) && $response === false) {
            return $response;
        } else {
            $customer = $response;

            $this->em->flush();

            return $customer;
        }
    }
}