<?php

namespace BeSimple\SsoAuthBundle\Controller;

use BeSimple\SsoAuthBundle\Sso\ProviderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

class TrustedSsoController extends Controller
{
    public function loginAction(ProviderInterface $provider, Request $request, AuthenticationException $exception = null)
    {
        return $this->render(
            'BeSimpleSsoAuthBundle:TrustedSso:login.html.twig',
            array('provider'  => $provider, 'request' => $request, 'exception' => $exception)
        );
    }

    public function logoutAction(ProviderInterface $provider, Request $request)
    {
        return $this->render(
            'BeSimpleSsoAuthBundle:TrustedSso:logout.html.twig',
            array('provider'  => $provider, 'request' => $request)
        );
    }
}