<?php

namespace spec\Message\Message;

use Customer\Customer\Customer;
use Message\Message\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MessageReceiverSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Message\Message\MessageReceiver');
    }

    public function it_implement_message_receiver_interface()
    {
        $this->shouldHaveType('Message\Message\MessageReceiverInterface');
    }

    public function it_construct_with_uniqid()
    {
        $id = uniqid();
        $this->beConstructedWith($id);
        $this->getId()->shouldBe($id);
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

    public function it_should_get_given_receivers()
    {
        $receivers = [1, 2, 3];
        $this->setReceivers($receivers);
        $this->getReceivers()->shouldBe($receivers);
    }

    public function it_should_add_and_get_received()
    {
        $received = new Customer();
        $this->addReceived($received);
        $this->getReceived()->shouldBe(array($received->getId() => $received->getId()));
    }
}
