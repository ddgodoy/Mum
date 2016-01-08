<?php

namespace spec\Message\Instant;

use Customer\Customer\Customer;
use Message\Message\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstantMessageSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Message\Instant\InstantMessage');
    }

    public function it_implement_email_message_interface()
    {
        $this->shouldHaveType('Message\Instant\InstantMessageInterface');
    }

    public function it_should_get_given_customer()
    {
        $customer = new Customer();
        $this->setCustomer($customer);
        $this->getCustomer()->shouldBe($customer);
    }

    public function it_should_get_given_message()
    {
        $message = new Message();
        $this->setMessage($message);
        $this->getMessage()->shouldBe($message);
    }
}
