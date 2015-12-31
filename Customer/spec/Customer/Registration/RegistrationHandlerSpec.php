<?php

namespace spec\Customer\Registration;

use Customer\Customer\Customer;
use Customer\Registration\RegistrationAttempt;
use Customer\Registration\RegistrationAttemptStatusConfirmed;
use Customer\Registration\RegistrationAttemptStatusCreated;
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
        $registrationAttempt = new RegistrationAttempt();
        $customer = $this->register($customer, $registrationAttempt);
        $customer->getEmail()->shouldBe(sprintf("%s@mum.com", $number));
        $customer->getRoles()->shouldHaveCount(1);
        $customer->getRoles()[0]->shouldBe('ROLE_USER');
        $customer->isEnabled()->shouldBe(false);
        $attempts = $customer->getRegistrationAttempts();
        $attempt = $attempts[count($attempts) - 1];
        $attempt->getStatus()->shouldBe((new RegistrationAttemptStatusCreated())->getId());
    }

    public function it_should_confirm_customer_by_attempt_token()
    {
        $id = uniqid();
        $customer = new Customer($id);
        $number = '1234567890';
        $customer->setUsername($number);
        $registrationAttempt = new RegistrationAttempt();
        $customer = $this->register($customer, $registrationAttempt);
        $registrationAttempt->nextStatus();
        $this->confirm($customer, $registrationAttempt);
        $customer->isEnabled()->shouldBe(true);
        expect($registrationAttempt->getStatus())->toBe((new RegistrationAttemptStatusConfirmed())->getId());
    }

    public function it_should_fail_confirming_customer_by_attempt_token_with_bad_attempt_status()
    {
        $id = uniqid();
        $customer = new Customer($id);
        $number = '1234567890';
        $customer->setUsername($number);
        $registrationAttempt = new RegistrationAttempt();
        $customer = $this->register($customer, $registrationAttempt);
        $response = $this->confirm($customer, $registrationAttempt);
        $response->shouldBe(false);
    }
}
