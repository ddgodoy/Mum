<?php

namespace Customer\Customer;

/**
 * Class CustomerProfile
 *
 * @package Customer\Customer
 */
class CustomerProfile implements CustomerProfileInterface
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $avatarURL;

    /**
     * @var array
     */
    protected $displayName;

    /**
     * @var CustomerInterface
     */
    protected $customer;

    /**
     * Customer constructor.
     *
     * @param string|null $id
     */
    public function __construct($id = null)
    {
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
     * Set the avatar url
     *
     * @param $avatarURL
     */
    public function setAvatarURL($avatarURL)
    {
        $this->avatarURL = $avatarURL;
    }

    /**
     * Get the avatar url
     *
     * @return string
     */
    public function getAvatarURL()
    {
        return $this->avatarURL;
    }

    /**
     * Set the display name
     *
     * @param $displayName
     */
    public function setDisplayName($displayName)
    {
        $this->displayName = $displayName;
    }

    /**
     * Get the display name
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->displayName;
    }

    /**
     * Set the customer
     *
     * @param CustomerInterface $customer
     */
    public function setCustomer(CustomerInterface $customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the customer
     *
     * @return CustomerInterface
     */
    public function getCustomer()
    {
        return $this->customer;
    }
}