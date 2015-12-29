<?php

namespace spec\Customer\OAuth;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Customer\OAuth\Client');
    }

    public function it_implement_oauth_client_interface()
    {
        $this->shouldHaveType('Customer\OAuth\OAuthClientInterface');
    }

    public function it_construct_with_uniqid_and_name()
    {
        $id = uniqid();
        $name = 'Test Client';
        $this->beConstructedWith($id, $name);
        $this->getId()->shouldBeLike($id);
        $this->getName()->shouldBeLike($name);
    }
}
