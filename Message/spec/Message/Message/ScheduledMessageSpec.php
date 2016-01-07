<?php

namespace spec\Message\Message;

use Customer\Customer\Customer;
use Message\Message\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScheduledMessageSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Message\Message\ScheduledMessage');
    }

    public function it_implement_message_receiver_interface()
    {
        $this->shouldHaveType('Message\Message\ScheduledMessageInterface');
    }

    public function it_should_get_given_message()
    {
        $message = new Message();
        $this->setMessage($message);
        $this->getMessage()->shouldBe($message);
    }

    public function it_should_get_given_customer()
    {
        $customer = new Customer();
        $this->setCustomer($customer);
        $this->getCustomer()->shouldBe($customer);
    }

    public function it_should_get_given_when()
    {
        $at = new \DateTime();
        $this->setAt($at);
        $this->getAt()->shouldBe($at);
    }

    public function it_should_flow_the_status()
    {
        $this->getStatus()->shouldBe(1);
        $this->nextStatus();
        $this->getStatus()->shouldBe(2);
        $this->nextStatus();
        $this->getStatus()->shouldBe(3);
    }
}
