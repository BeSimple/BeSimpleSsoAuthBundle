<?php

namespace BeSimple\SsoAuthBundle\Security\Http\Firewall;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Log\LoggerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\Security\Http\Session\SessionAuthenticationStrategyInterface;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Http\Firewall\AbstractAuthenticationListener;
use Symfony\Component\Security\Http\HttpUtils;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use BeSimple\SsoAuthBundle\Security\Core\Authentication\Provider\SsoAuthenticationProvider;
use BeSimple\SsoAuthBundle\Sso\Factory;

class TrustedSsoAuthenticationListener extends AbstractAuthenticationListener
{
    private $factory;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, SessionAuthenticationStrategyInterface $sessionStrategy, HttpUtils $httpUtils, $providerKey, Factory $factory, array $options = array(), AuthenticationSuccessHandlerInterface $successHandler = null, AuthenticationFailureHandlerInterface $failureHandler = null, LoggerInterface $logger = null, EventDispatcherInterface $dispatcher = null)
    {
        parent::__construct($securityContext, $authenticationManager, $sessionStrategy, $httpUtils, $providerKey, $options, $successHandler, $failureHandler, $logger, $dispatcher);

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
