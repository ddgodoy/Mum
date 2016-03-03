<?php

namespace AppBundle\Services;

use AppBundle\Entity\RegistrationAttempt;
use Customer\Customer\CustomerInterface;
use Customer\Registration\RegistrationAttemptInterface;
use Customer\Registration\RegistrationHandler;
use Doctrine\ORM\EntityManager;

/**
 * Class CustomerRegistration
 *
 * @package AppBundle\Services
 */
class CustomerRegistration
{
    /**
     * @var Twilio
     */
    private $twilio;

    /**
     * @var EntityManager
     */
    private $em;

    /**
     * CustomerRegistration constructor.
     *
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
     * @param string $countryCode
     * @param string $phoneNumber
     * @return mixed
     */
    public function register(CustomerInterface $customer, $countryCode, $phoneNumber)
    {
        if (substr($countryCode, 0, 1) === '+') {
            $countryCode = substr($countryCode, 1);
        }

        if (substr($phoneNumber, 0, 1) === '0') {
            $phoneNumber = substr($phoneNumber, 1);
        }

        $username = sprintf("%s%s", $countryCode, $phoneNumber);

        // try to find an already registered customer
        $customers = $this->em->getRepository('AppBundle:Customer')->findByUsername($username);
        // if the user is already registered use it
        if (count($customers)) {
            $customer = $customers[0];
        } else {
            // setup base data
            $customer->setUsername($username);
            $customer->setCountryCode($countryCode);
            $customer->setPhoneNumber($phoneNumber);
        }

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
        $this->em->persist($customer);
        $attempt->setCustomer($customer);
        $this->em->persist($attempt);
        $this->em->flush();

        return [
            'customer' => $customer,
            'attempt' => $attempt
        ];
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