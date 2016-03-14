<?php

namespace AppBundle\ResponseObjects;

use Customer\Customer\CustomerProfileInterface;

/**
 * Class CustomerProfile
 *
 * @package AppBundle\ResponseObjects
 */
class CustomerProfile
{
    /**
     * @var string
     */
    public $avatarURL;

    /**
     * @var string
     */
    public $displayName;

    /**
     * CustomerProfile constructor.
     *
     * @param CustomerProfileInterface $customerProfile
     */
    public function __construct(CustomerProfileInterface $customerProfile)
    {
        $this->avatarURL = $customerProfile->getAvatarURL();
        $this->displayName = $customerProfile->getDisplayName();
    }
}