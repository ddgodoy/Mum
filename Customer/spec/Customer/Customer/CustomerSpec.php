<?php

namespace spec\Customer\Customer;

use Customer\Customer\Customer;
use Customer\Customer\CustomerProfile;
use Customer\Registration\RegistrationAttempt;
use Doctrine\Common\Collections\ArrayCollection;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CustomerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Customer\Customer\Customer');
    }

    public function it_is_fosuserbundle_entity()
    {
        $this->shouldHaveType('FOS\UserBundle\Model\User');
    }

    public function it_implement_symfony_advanced_user_interface()
    {
        $this->shouldHaveType('Symfony\Component\Security\Core\User\AdvancedUserInterface');
    }

    public function it_construct_with_uniqid()
    {
        $id = uniqid();
        $this->beConstructedWith($id);
        $this->getId()->shouldBe($id);
    }

    public function it_should_add_new_registration_attempt()
    {
        $registrationAttempt = new RegistrationAttempt();
        $this->addRegistrationAttempt($registrationAttempt);
        $this->getRegistrationAttempts()->shouldHaveCount(1);
        $this->getRegistrationAttempts()[0]->shouldBe($registrationAttempt);
    }

    public function it_should_store_a_profile()
    {
        $profile = new CustomerProfile();
        $profile->setAvatarURL('www.avatar.com');
        $profile->setDisplayName('Display Name');
        $this->setProfile($profile);
        $this->getProfile()->shouldBe($profile);
    }

    public function it_should_store_contacts()
    {
        $contact = new Customer();
        $contacts = new ArrayCollection();
        $contacts->add($contact);
        $this->setContacts($contacts);
        $this->getContacts()->shouldBe($contacts);
        $contact2 = new Customer();
        $contacts->add($contact2);
        $this->addContact($contact2);
        $this->getContacts()->shouldBe($contacts);
    }
}
