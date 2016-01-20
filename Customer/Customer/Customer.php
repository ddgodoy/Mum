<?php

namespace Customer\Customer;

use Customer\Registration\RegistrationAttemptInterface;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class Customer
 *
 * @package Customer\Entity
 */
class Customer extends BaseUser implements CustomerInterface
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $registrationAttempts;

    /**
     * @var CustomerProfile
     */
    protected $profile;

    /**
     * Customer constructor.
     * @param string|null $id
     */
    public function __construct($id = null)
    {
        parent::__construct();

        $this->id = $id;
        if (!$this->id) {
            $this->id = uniqid();
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
    public function addRegistrationAttempt(RegistrationAttemptInterface $attempt)
    {
        $this->registrationAttempts[] = $attempt;
    }

    /**
     * @inheritdoc
     */
    public function getRegistrationAttempts()
    {
        return $this->registrationAttempts;
    }

    /**
     * Set the profile
     *
     * @param CustomerProfile $customerProfile
     */
    public function setProfile(CustomerProfile $customerProfile)
    {
        $this->profile = $customerProfile;
    }

    /**
     * Get the profile
     *
     * @return CustomerProfile
     */
    public function getProfile()
    {
        return $this->profile;
    }
}