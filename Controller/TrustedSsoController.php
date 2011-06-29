<?php

namespace BeSimple\SsoAuthBundle\Controller;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use BeSimple\SsoAuthBundle\Sso\SsoProviderInterface;

class TrustedSsoController extends ContainerAware
{
    public function loginAction(SsoProviderInterface $provider, Request $request, AuthenticationException $exception = null)
    {
        $view       = 'BeSimpleSsoAuthBundle:TrustedSso:login.html.twig';
        $parameters = array('provider'  => $provider, 'request' => $request, 'exception' => $exception);

        return $this->container->get('templating')->renderResponse($view, $parameters);
    }
}