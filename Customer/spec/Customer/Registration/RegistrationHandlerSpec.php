<?php

namespace spec\Customer\Registration;

use Customer\Customer\Customer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegistrationHandlerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Customer\Registration\RegistrationHandler');
    }

    public function it_should_register_new_attempt_on_customer()
    {
        $id = uniqid();
        $customer = new Customer($id);
        $number = '1234567890';
        $customer->setUsername($number);
        $customer = $this->handle($customer);
        $customer->getEmail()->shouldBeLike(sprintf("%s@mum.com", $number));
        $customer->getRoles()->shouldHaveCount(1);
        $customer->getRoles()[0]->shouldBeLike('ROLE_USER');
    }
}
