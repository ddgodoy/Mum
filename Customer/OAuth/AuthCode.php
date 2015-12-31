<?php

namespace Customer\OAuth;

use Customer\Customer\CustomerInterface;
use FOS\OAuthServerBundle\Entity\AuthCode as BaseAuthCode;

/**
 * Class AuthCode
 *
 * @package Customer\Entity
 */
class AuthCode extends BaseAuthCode implements OAuthTokenInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var OAuthClientInterface
     */
    protected $client;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * AuthCode constructor.
     * @param null $id
     * @param OAuthClientInterface|null $client
     * @param CustomerInterface|null $customer
     */
    public function __construct($id = null, OAuthClientInterface $client = null, CustomerInterface $customer = null)
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
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @inheritdoc
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}