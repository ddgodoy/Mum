<?php

namespace Customer\Customer;

use Customer\Registration\RegistrationAttemptInterface;
use Doctrine\Common\Collections\ArrayCollection;
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
     * @var array
     */
    protected $accessTokens;

    /**
     * @var array
     */
    protected $authCodes;

    /**
     * @var array
     */
    protected $refreshTokens;

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
        $this->id = $id;
        if (!$this->id) {
            $this->id = uniqid();
        }
        $this->registrationAttempts = new ArrayCollection();
        $this->accessTokens = new ArrayCollection();
        $this->authCodes = new ArrayCollection();
        $this->refreshTokens = new ArrayCollection();
        parent::__construct();
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