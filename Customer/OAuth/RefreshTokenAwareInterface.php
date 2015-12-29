<?php

namespace Customer\OAuth;

/**
 * Interface RefreshTokenAwareInterface
 * @package Customer\OAuth
 */
interface RefreshTokenAwareInterface
{
    /**
     * Set the refresh token
     *
     * @param RefreshToken $token
     * @return mixed
     */
    public function setRefreshToken(RefreshToken $token);

    /**
     * Get all the refresh tokens
     *
     * @return mixed
     */
    public function getRefreshTokens();
}