<?php

namespace Message\Message;
use Customer\Customer\CustomerInterface;

/**
 * Interface CustomerDependantInterface
 *
 * @package Message\Message
 */
interface CustomerDependantInterface
{
    /**
     * Set the Message Customer sender
     *
     * @param CustomerInterface $customer
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Get the Message Customer sender
     *
     * @return CustomerInterface
     */
    public function getCustomer();
}