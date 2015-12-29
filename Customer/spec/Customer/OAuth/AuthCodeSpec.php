<?php

namespace spec\Customer\OAuth;

use Customer\Customer\Customer;
use Customer\OAuth\Client;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class AuthCodeSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Customer\OAuth\AuthCode');
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
        $this->getId()->shouldBeLike($id);
        $this->getClient()->shouldHaveType('Customer\OAuth\Client');
        $this->getClient()->shouldBeLike($client);
    }

    public function it_construct_with_uniqid_client_and_customer()
    {
        $id = uniqid();
        $client = new Client();
        $customer = new Customer();
        $this->beConstructedWith($id, $client, $customer);
        $this->getId()->shouldBeLike($id);
        $this->getClient()->shouldHaveType('Customer\OAuth\Client');
        $this->getClient()->shouldBeLike($client);
        $this->getCustomer()->shouldHaveType('Customer\Customer\Customer');
        $this->getCustomer()->shouldBeLike($customer);
    }
}
