<?php

namespace BeSimple\SsoAuthBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;

class TrustedSsoController
{
    const LOGIN_REQUIRED_RESPONSE = 'login required';

    public function loginAction(SsoProviderInterface $provider, Request $request, AuthenticationException $exception = null)
    {
        return new Response(self::LOGIN_REQUIRED_RESPONSE);
    }
}