<?php

namespace AppBundle\ResponseObjects;

use Customer\Customer\CustomerInterface;

/**
 * Class CustomerAuth
 *
 * @package AppBundle\ResponseObjects
 */
class CustomerAuth
{

    /**
     * @var string
     */
    public $username;

    /**
     * @var string
     */
    public $password;

    /**
     * Customer constructor.
     *
     * @param CustomerInterface $customer
     */
    public function __construct(CustomerInterface $customer)
    {
        $this->username = $customer->getUsername();
        $this->password = $customer->getPassword();
    }
}