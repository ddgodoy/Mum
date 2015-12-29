<?php

namespace Customer\Entity;

/**
 * Interface OAuthTokenInterface
 * @package Customer\Entity
 */
interface OAuthTokenInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return Client
     */
    public function getClient();

    /**
     * @return Customer
     */
    public function getCustomer();
}