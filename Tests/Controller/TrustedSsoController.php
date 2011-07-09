<?php

namespace BeSimple\SsoAuthBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;

class TrustedSsoController extends Controller
{
    const LOGIN_REQUIRED_MESSAGE = 'login required';

    public function loginAction(SsoProviderInterface $provider, Request $request, AuthenticationException $exception = null)
    {
        return $this->render('common/trusted_login.html.twig', array(
            'message' => self::LOGIN_REQUIRED_MESSAGE,
            'url'     => $provider->getServer()->getLoginUrl()
        ));
    }
}