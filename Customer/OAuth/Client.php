<?php

namespace Customer\OAuth;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\OAuthServerBundle\Entity\Client as BaseClient;

/**
 * Class Client
 *
 * @package Customer\Entity
 */
class Client extends BaseClient implements OAuthClientInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

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
     * Client constructor.
     * @param null $id
     * @param null $name
     */
    public function __construct($id = null, $name = null)
    {
        if ($id) {
            $this->id = $id;
        } else {
            $this->id = uniqid();
        }
        if ($name) {
            $this->name = $name;
        }
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        $this->name = $name;
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
}