<?php

namespace Customer\OAuth;

/**
 * Interface AuthCodeAwareInterface
 * @package Customer\OAuth
 */
interface AuthCodeAwareInterface
{
    /**
     * Set the auth code
     *
     * @param AuthCode $authCode
     * @return mixed
     */
    public function setAuthCode(AuthCode $authCode);

    /**
     * Get all the auth codes
     *
     * @return mixed
     */
    public function getAuthCodes();
}