<?php

namespace Customer\Registration;

use Customer\Customer\CustomerInterface;

/**
 * Class RegistrationHandler
 *
 * @package Customer\Registration
 */
class RegistrationHandler
{
    /**
     * Handle a new customer registration logic
     *
     * @param CustomerInterface $customer
     * @param RegistrationAttemptInterface $registrationAttempt
     * @return CustomerInterface
     */
    public function register(CustomerInterface $customer, RegistrationAttemptInterface $registrationAttempt)
    {
        $customer->setEmail(sprintf("%s@mum.com", $customer->getUsername()));
        $customer->setPlainPassword(uniqid($customer->getUsername()));
        $customer->setRoles(array('ROLE_USER'));
        $customer->addRegistrationAttempt($registrationAttempt);
        return $customer;
    }

    /**
     * Handler the confirmation of a customer through the registration attempt token
     *
     * @param CustomerInterface $customer
     * @param RegistrationAttemptInterface $registrationAttempt
     * @return CustomerInterface
     */
    public function confirm(CustomerInterface $customer, RegistrationAttemptInterface $registrationAttempt)
    {
        if ($registrationAttempt->getStatus() !== (new RegistrationAttemptStatusSent())->getId()) {
            return false;
        }

        // update customer
        $customer->setEnabled(true);

        // update registration Attempt
        $registrationAttempt->nextStatus();

        return $customer;
    }
}