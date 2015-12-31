<?php

namespace spec\Customer\Customer;

use Customer\Registration\RegistrationAttempt;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CustomerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Customer\Customer\CustomerProfile');
    }

    public function it_implement_symfony_advanced_user_interface()
    {
        $this->shouldHaveType('Customer\Customer\CustomerProfileInterface');
    }

    public function it_construct_with_uniqid()
    {
        $id = uniqid();
        $this->beConstructedWith($id);
        $this->getId()->shouldBe($id);
    }
}
