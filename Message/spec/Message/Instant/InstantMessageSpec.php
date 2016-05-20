<?php

namespace spec\Message\Instant;

use Customer\Customer\Customer;
use Message\Instant\Room;
use Message\Message\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class InstantMessageSpec extends ObjectBehavior
{
    public function it_implement_email_message_interface()
    {
        $this->shouldHaveType('Message\Instant\InstantMessageInterface');
    }

    public function it_construct_with_uniqid()
    {
        $id = uniqid();
        $room = new Room($id);
        $this->beConstructedWith($room);
        $this->getRoom()->shouldBe($room);
        $this->getReceived()->shouldBe(false);
    }

    public function it_should_set_and_customer()
    {
        $customer = new Customer();
        $this->setCustomer($customer);
        $this->getCustomer()->shouldBe($customer);
    }

    public function it_should_get_message()
    {
        $message = new Message();
        $this->setMessage($message);
        $this->getMessage()->shouldBe($message);
    }

    public function it_should_set_and_get_received()
    {
        $received = true;
        $this->setReceived($received);
        $this->getReceived()->shouldBe($received);
    }
}
