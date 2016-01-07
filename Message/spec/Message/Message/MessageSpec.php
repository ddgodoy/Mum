<?php

namespace spec\Message\Message;

use Customer\Customer\Customer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Message\Message\Message');
    }

    public function it_implement_message_interface()
    {
        $this->shouldHaveType('Message\Message\MessageInterface');
    }

    public function it_construct_with_uniqid()
    {
        $id = uniqid();
        $this->beConstructedWith($id);
        $this->getId()->shouldBe($id);
    }

    public function it_should_get_given_customer()
    {
        $customer = new Customer();
        $this->setCustomer($customer);
        $this->getCustomer()->shouldBe($customer);
    }

    public function it_should_get_given_body()
    {
        $body = "message body";
        $this->setBody($body);
        $this->getBody()->shouldBe($body);
    }
}
