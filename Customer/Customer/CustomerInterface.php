<?php

namespace Customer\Customer;

use Customer\Registration\RegistrationAttemptInterface;

/**
 * Interface Customer
 *
 * @package Customer\Entity
 */
interface CustomerInterface
{
    /**
     * Get Customer id
     *
     * @return string
     */
    public function getId();

    /**
     * Add new registration attempt
     *
     * @param RegistrationAttemptInterface $attempt
     * @return mixed
     */
    public function addRegistrationAttempt(RegistrationAttemptInterface $attempt);

    /**
     * @return array
     */
    public function getRegistrationAttempts();
}