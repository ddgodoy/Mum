<?php

namespace AppBundle\ResponseObjects;

use Customer\Customer\CustomerInterface;
use Customer\Registration\RegistrationAttemptInterface;

/**
 * Class CustomerRegistration
 *
 * @package AppBundle\ResponseObjects
 */
class CustomerRegistration
{

    /**
     * @var string
     */
    public $customer;

    /**
     * @var string
     */
    public $registrationAttempt;

    /**
     * CustomerRegistration constructor.
     *
     * @param CustomerInterface $customer
     * @param RegistrationAttemptInterface $registrationAttempt
     */
    public function __construct(CustomerInterface $customer, RegistrationAttemptInterface $registrationAttempt)
    {
        $this->customer = $customer->getId();
        $this->registrationAttempt = $registrationAttempt->getId();
    }
}