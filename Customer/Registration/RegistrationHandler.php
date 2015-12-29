<?php

namespace Customer\Registration;

use Customer\Customer\CustomerInterface;

class RegistrationHandler
{
    /**
     * Handle a new customer registration logic
     *
     * @param CustomerInterface $customer
     * @param RegistrationAttemptInterface $registrationAttempt
     * @return CustomerInterface
     */
    public function handle(CustomerInterface $customer, RegistrationAttemptInterface $registrationAttempt)
    {
        $customer->addRegistrationAttempt($registrationAttempt);
        $customer->setEmail(sprintf("%s@mum.com", $customer->getUsername()));
        $customer->setPlainPassword(uniqid($customer->getUsername()));
        $customer->setRoles(array('ROLE_USER'));
        return $customer;
    }
}