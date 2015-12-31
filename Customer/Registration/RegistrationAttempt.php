<?php

namespace Customer\Registration;

use Customer\Customer\CustomerInterface;

/**
 * Class RegistrationAttempt
 *
 * @package Customer\Registration
 */
class RegistrationAttempt implements RegistrationAttemptInterface
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var integer
     */
    protected $status;

    /**
     * @var string
     */
    protected $smsId;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * RegistrationAttempt constructor.
     * @param null $id
     */
    public function __construct($id = null)
    {
        $this->id = $id;
        if (!$this->id) {
            $this->id = uniqid();
        }
        $this->token = mt_rand(100000, 999999);
        $this->status = new RegistrationAttemptStatusCreated();
    }

    /**
     * Get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @inheritdoc
     */
    public function getStatus()
    {
        return $this->status->getId();
    }

    /**
     * @inheritdoc
     */
    public function nextStatus()
    {
        $this->status = $this->status->next();
    }

    /**
     * @inheritdoc
     */
    public function getSMSId()
    {
        return $this->smsId;
    }

    /**
     * @inheritdoc
     */
    public function setSMSId($id)
    {
        $this->smsId = $id;
    }

    /**
     * @inheritdoc
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @inheritdoc
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }
}