<?php

namespace spec\Customer\OAuth;

use Customer\Customer\Customer;
use Customer\OAuth\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RefreshTokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Customer\OAuth\RefreshToken');
    }

    public function it_implement_oauth_token_interface()
    {
        $this->shouldHaveType('Customer\OAuth\OAuthTokenInterface');
    }

    public function it_construct_with_uniqid_and_client()
    {
        $id = uniqid();
        $client = new Client();
        $this->beConstructedWith($id, $client);
        $this->getId()->shouldBe($id);
        $this->getClient()->shouldHaveType('Customer\OAuth\Client');
        $this->getClient()->shouldBe($client);
    }

    public function it_construct_with_uniqid_client_and_customer()
    {
        $id = uniqid();
        $client = new Client();
        $customer = new Customer();
        $this->beConstructedWith($id, $client, $customer);
        $this->getId()->shouldBe($id);
        $this->getClient()->shouldHaveType('Customer\OAuth\Client');
        $this->getClient()->shouldBe($client);
        $this->getCustomer()->shouldHaveType('Customer\Customer\Customer');
        $this->getCustomer()->shouldBe($customer);
    }
}
