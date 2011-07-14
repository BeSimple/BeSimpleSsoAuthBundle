<?php

namespace BeSimple\SsoAuthBundle\Tests\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;

class TrustedSsoController extends Controller
{
    const LOGIN_REQUIRED_MESSAGE  = 'login required';
    const LOGOUT_REDIRECT_MESSAGE = 'logout redirection';

    public function loginAction(SsoProviderInterface $provider, Request $request, AuthenticationException $exception = null)
    {
        return $this->render('common/link.html.twig', array(
            'message' => self::LOGIN_REQUIRED_MESSAGE,
            'url'     => $provider->getServer()->getLoginUrl()
        ));
    }

    public function logoutAction(SsoProviderInterface $provider, Request $request)
    {
        return $this->render('common/link.html.twig', array(
            'message' => self::LOGOUT_REDIRECT_MESSAGE,
            'url'     => $provider->getServer()->getLogoutUrl()
        ));
    }
}