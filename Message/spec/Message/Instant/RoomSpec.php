<?php

namespace spec\Message\Instant;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RoomSpec extends ObjectBehavior
{

    public function it_implement_email_message_interface()
    {
        $this->shouldHaveType('Message\Instant\RoomInterface');
    }

    public function it_construct_with_uniqid()
    {
        $id = uniqid();
        $this->beConstructedWith($id);
        $this->getId()->shouldBe($id);
    }
}
