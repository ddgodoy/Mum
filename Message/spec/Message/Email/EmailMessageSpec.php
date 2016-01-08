<?php

namespace spec\Message\Email;

use Customer\Customer\Customer;
use Message\Message\Message;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EmailMessageSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Message\Email\EmailMessage');
    }

    public function it_implement_email_message_interface()
    {
        $this->shouldHaveType('Message\Email\EmailMessageInterface');
    }

    public function it_should_get_given_customer()
    {
        $customer = new Customer();
        $this->setCustomer($customer);
        $this->getCustomer()->shouldBe($customer);
    }

    public function it_should_get_given_about()
    {
        $about = 'about';
        $this->setAbout($about);
        $this->getAbout()->shouldBe($about);
    }

    public function it_should_get_given_fromAddress()
    {
        $from = 'from';
        $this->setFromAddress($from);
        $this->getFromAddress()->shouldBe($from);
    }

    public function it_should_get_given_message()
    {
        $message = new Message();
        $this->setMessage($message);
        $this->getMessage()->shouldBe($message);
    }
}
