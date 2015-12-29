<?php

namespace Customer\Entity;

/**
 * Class AccessToken
 * @package Customer\Entity
 */
class AccessToken implements OAuthTokenInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var Client
     */
    protected $client;

    /**
     * @var Customer
     */
    protected $customer;

    /**
     * AccessToken constructor.
     * @param null $id
     * @param Client|null $client
     * @param Customer|null $customer
     */
    public function __construct($id = null, Client $client = null, Customer $customer = null)
    {
        if ($id) {
            $this->id = $id;
        } else {
            $this->id = uniqid();
        }

        if ($client) {
            $this->client = $client;
        }

        if ($customer) {
            $this->customer = $customer;
        }
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Client|null
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return Customer
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}