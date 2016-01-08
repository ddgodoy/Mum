<?php

namespace Scheduler\Scheduler;

use Customer\Customer\CustomerInterface;

/**
 * Interface MessageInterface
 *
 * @package Scheduler\Scheduler
 */
interface MessageInterface
{
    /**
     * Get the Message id
     *
     * @return string
     */
    public function getId();

    /**
     * Set Message Customer sender
     *
     * @param CustomerInterface $customer
     */
    public function setCustomer(CustomerInterface $customer);

    /**
     * Get the customer sender
     *
     * @return CustomerInterface
     */
    public function getCustomer();

    /**
     * Set the Message body
     *
     * @param string $body
     */
    public function setBody($body);

    /**
     * Get the Message body
     *
     * @return string
     */
    public function getBody();
}