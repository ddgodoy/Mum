<?php

namespace spec\Customer\Registration;

use Customer\Customer\Customer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RegistrationAttemptSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Customer\Registration\RegistrationAttempt');
    }

    public function it_implement_symfony_advanced_user_interface()
    {
        $this->shouldHaveType('Customer\Registration\RegistrationAttemptInterface');
    }

    public function it_construct_with_uniqid()
    {
        $id = uniqid();
        $this->beConstructedWith($id);
        $this->getId()->shouldBeLike($id);
    }

    public function it_should_have_an_integer_as_token()
    {
        $this->getToken()->shouldBeInteger();
    }

    public function it_should_have_six_digits()
    {
        $this->getToken()->shouldHaveDigits(6);
    }

    public function it_should_flow_the_status()
    {
        $this->getStatus()->shouldBeLike(1);
        $this->nextStatus();
        $this->getStatus()->shouldBeLike(2);
        $this->nextStatus();
        $this->getStatus()->shouldBeLike(3);
    }

    public function it_should_set_sms_id()
    {
        $this->setSMSId('1234567890');
        $this->getSMSId()->shouldBeLike('1234567890');
    }

    public function it_should_set_customer()
    {
        $customer = new Customer();
        $this->setCustomer($customer);
        $this->getCustomer()->shouldBeLike($customer);
    }

    public function getMatchers()
    {
        return [
            'haveDigits' => function ($subject, $length) {
                return strlen($subject) === $length;
            }
        ];
    }
}
