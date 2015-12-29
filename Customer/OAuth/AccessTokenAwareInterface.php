<?php

namespace Customer\OAuth;

/**
 * Interface AccessTokenAwareInterface
 * @package Customer\OAuth
 */
interface AccessTokenAwareInterface
{
    /**
     * Set access token
     *
     * @param AccessToken $accessToken
     * @return mixed
     */
    public function setAccessToken(AccessToken $accessToken);

    /**
     * Get all the access tokens
     *
     * @return mixed
     */
    public function getAccessTokens();
}