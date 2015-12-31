<?php

namespace Customer\Customer;

use Customer\OAuth\AccessToken;
use Customer\OAuth\AccessTokenAwareInterface;
use Customer\OAuth\AuthCode;
use Customer\OAuth\AuthCodeAwareInterface;
use Customer\OAuth\RefreshToken;
use Customer\OAuth\RefreshTokenAwareInterface;
use Customer\Registration\RegistrationAttemptInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class Customer
 *
 * @package Customer\Entity
 */
class Customer extends BaseUser implements CustomerInterface,
    AccessTokenAwareInterface,
    AuthCodeAwareInterface,
    RefreshTokenAwareInterface
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
     * @param null $id
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
     * @inheritdoc
     */
    public function setAccessToken(AccessToken $token)
    {
        $this->accessTokens[] = $token;
    }

    /**
     * @inheritdoc
     */
    public function getAccessTokens()
    {
        return $this->accessTokens;
    }

    /**
     * @inheritdoc
     */
    public function setAuthCode(AuthCode $authCode)
    {
        $this->authCodes[] = $authCode;
    }

    /**
     * @inheritdoc
     */
    public function getAuthCodes()
    {
        return $this->authCodes;
    }

    /**
     * @inheritdoc
     */
    public function setRefreshToken(RefreshToken $token)
    {
        $this->refreshTokens[] = $token;
    }

    /**
     * @inheritdoc
     */
    public function getRefreshTokens()
    {
        return $this->refreshTokens;
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