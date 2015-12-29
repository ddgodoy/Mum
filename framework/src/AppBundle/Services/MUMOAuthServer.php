<?php

namespace AppBundle\Services;

use OAuth2\OAuth2;
use Symfony\Component\HttpFoundation\Request;

class MUMOAuthServer extends OAuth2
{

    /**
     * @inheritdoc
     */
    public function grantAccessToken(Request $request = null)
    {
        $request->query->add(array("username" => $request->headers->get("username"), "password" => $request->headers->get("password")));
        return parent::grantAccessToken($request);
    }
}