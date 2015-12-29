<?php

namespace Customer\Registration;

use Customer\Customer\CustomerInterface;

interface RegistrationAttemptInterface
{
    /**
     * Get id
     *
     * @return string
     */
    public function getId();

    /**
     * Get token
     *
     * @return string
     */
    public function getToken();

    /**
     * Update the status
     *
     * @return RegistrationAttemptStatusInterface
     */
    public function nextStatus();

    /**
     * Get current status
     *
     * @return int
     */
    public function getStatus();

    /**
     * Set SMS sent id
     *
     * @param $id
     */
    public function setSMSId($id);

    /**
     * Get SMS sent id
     *
     * @return mixed
     */
    public function getSMSId();

    /**
     * Set the customer
     *
     * @param CustomerInterface $customer
     * @return mixed
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Get the customer
     *
     * @return CustomerInterface
     */
    public function getCustomer();
}