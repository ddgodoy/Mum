<?php

namespace Customer\Customer;

/**
 * Interface CustomerInterface
 *
 * @package Customer\Customer
 */
interface CustomerProfileInterface
{
    /**
     * Get avatar url
     *
     * @return string
     */
    public function getAvatarURL();

    /**
     * Get display name
     *
     * @return string
     */
    public function getDisplayName();
}