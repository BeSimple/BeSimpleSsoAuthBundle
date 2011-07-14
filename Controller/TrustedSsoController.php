<?php

namespace BeSimple\SsoAuthBundle\Controller;

use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TrustedSsoController extends Controller
{
    public function loginAction(SsoProviderInterface $provider, Request $request, AuthenticationException $exception = null)
    {
        return $this->render(
            'BeSimpleSsoAuthBundle:TrustedSso:login.html.twig',
            array('provider'  => $provider, 'request' => $request, 'exception' => $exception)
        );
    }

    public function logoutAction(SsoProviderInterface $provider, Request $request)
    {
        return $this->render(
            'BeSimpleSsoAuthBundle:TrustedSso:logout.html.twig',
            array('provider'  => $provider, 'request' => $request)
        );
    }
}