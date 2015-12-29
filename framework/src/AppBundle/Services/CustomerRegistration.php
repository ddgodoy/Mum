<?php

namespace AppBundle\Services;

use AppBundle\Entity\Customer;
use AppBundle\Entity\RegistrationAttempt;
use Customer\Registration\RegistrationHandler;
use Doctrine\ORM\EntityManager;

/**
 * Class CustomerRegistration
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
     * Handler the registration attempt
     *
     * @param Customer $customer
     * @return Customer
     */
    public function handle(Customer $customer)
    {
        // perform business registration
        $registrationAttempt = new RegistrationAttempt();
        $handler = new RegistrationHandler();
        $handler->handle($customer, $registrationAttempt);

        // send confirmation token by sms
        $attempts = $customer->getRegistrationAttempts();
        $attempt = $attempts[count($attempts) - 1];
        $message = sprintf('Your confirmation number is %s', $attempt->getToken());
        $to = sprintf('+%s', $customer->getUsername());
        $messageId = $this->twilio->sendToNumber($message, $to);
        $attempt->setSMSId($messageId);
        $attempt->setCustomer($customer);

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
}