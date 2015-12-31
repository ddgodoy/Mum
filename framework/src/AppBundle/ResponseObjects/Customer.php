<?php

namespace AppBundle\ResponseObjects;

use Customer\Customer\CustomerInterface;

/**
 * Class Customer
 *
 * @package AppBundle\ResponseObjects
 */
class Customer
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $username;

    /**
     * @var CustomerProfile
     */
    public $profile;

    /**
     * Customer constructor.
     *
     * @param CustomerInterface $customer
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->id = $customer->getId();
        $this->username = $customer->getUsername();
        $this->profile = new CustomerProfile($customer->getProfile());
    }
}