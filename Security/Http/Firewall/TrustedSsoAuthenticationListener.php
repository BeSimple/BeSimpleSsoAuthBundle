<?php

namespace BeSimple\SsoAuthBundle\Security\Http\Firewall;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use BeSimple\SsoAuthBundle\Sso\Factory;

class TrustedSsoAuthenticationListener extends AbstractAuthenticationListener
{
    private $factory;

    public function setFactory(Factory $factory)
    {
        $this->factory = $factory;
    }

    protected function attemptAuthentication(Request $request)
    {
        $manager = $this->factory->getManager($this->options['manager'], $request->getUriForPath($this->options['check_path']));

        if (!$manager->getProtocol()->isValidationRequest($request)) {
            return null;
        }

        return $this->authenticationManager->authenticate($manager->createToken($request));
    }
}
