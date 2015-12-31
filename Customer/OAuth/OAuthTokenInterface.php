<?php

namespace Customer\OAuth;

use Customer\Customer\CustomerInterface;

/**
 * Interface OAuthTokenInterface
 *
 * @package Customer\Entity
 */
interface OAuthTokenInterface
{
    /**
     * @return string
     */
    public function getId();

    /**
     * @return OAuthClientInterface
     */
    public function getClient();

    /**
     * @return CustomerInterface
     */
    public function getCustomer();
}