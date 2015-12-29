<?php

namespace AppBundle\Security\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class RestUserToken extends AbstractToken
{
    private $password;

    public function __construct($password)
    {
        $this->password = $password;
        parent::__construct();
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getCredentials()
    {
        return '';
    }
}