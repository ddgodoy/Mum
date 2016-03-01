<?php

namespace Customer\Customer;

use Customer\Registration\RegistrationAttemptInterface;
use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Model\User as BaseUser;

/**
 * Class Customer
 *
 * @package Customer\Customer
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
     * @var CustomerProfileInterface
     */
    protected $profile;

    /**
     * @var ArrayCollection
     */
    protected $contacts;

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
        $this->contacts = new ArrayCollection();
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
     * @param CustomerProfileInterface $customerProfile
     */
    public function setProfile(CustomerProfileInterface $customerProfile)
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

    /**
     * Set contacts
     *
     * @param ArrayCollection $contacts
     */
    public function setContacts(ArrayCollection $contacts)
    {
        $this->contacts = $contacts;
    }

    /**
     * Add new contact
     *
     * @param CustomerInterface $contact
     */
    public function addContact(CustomerInterface $contact)
    {
        $this->contacts->add($contact);
    }

    /**
     * Remove contact
     *
     * @param CustomerInterface $contact
     */
    public function removeContact(CustomerInterface $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contacts
     *
     * @return ArrayCollection
     */
    public function getContacts()
    {
        return $this->contacts;
    }
}