<?php

namespace spec\Customer\Entity;

use Customer\Entity\Client;
use Customer\Entity\Customer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RefreshTokenSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Customer\Entity\RefreshToken');
    }

    public function it_implement_oauth_token_interface()
    {
        $this->shouldHaveType('Customer\Entity\OAuthTokenInterface');
    }

    public function it_construct_with_uniqid_and_client()
    {
        $id = uniqid();
        $client = new Client();
        $this->beConstructedWith($id, $client);
        $this->getId()->shouldBeLike($id);
        $this->getClient()->shouldHaveType('Customer\Entity\Client');
        $this->getClient()->shouldBeLike($client);
    }

    public function it_construct_with_uniqid_client_and_customer()
    {
        $id = uniqid();
        $client = new Client();
        $customer = new Customer();
        $this->beConstructedWith($id, $client, $customer);
        $this->getId()->shouldBeLike($id);
        $this->getClient()->shouldHaveType('Customer\Entity\Client');
        $this->getClient()->shouldBeLike($client);
        $this->getCustomer()->shouldHaveType('Customer\Entity\Customer');
        $this->getCustomer()->shouldBeLike($customer);
    }
}
