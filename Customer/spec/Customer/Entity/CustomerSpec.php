<?php

namespace spec\Customer\Entity;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CustomerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Customer\Entity\Customer');
    }

    public function it_is_fosuserbundle_entity()
    {
        $this->shouldHaveType('FOS\UserBundle\Model\User');
    }

    public function it_implement_symfony_advanced_user_interface()
    {
        $this->shouldHaveType('Symfony\Component\Security\Core\User\AdvancedUserInterface');
    }

    public function it_construct_with_uniqid()
    {
        $id = uniqid();
        $this->beConstructedWith($id);
        $this->getId()->shouldBeLike($id);
    }
}
