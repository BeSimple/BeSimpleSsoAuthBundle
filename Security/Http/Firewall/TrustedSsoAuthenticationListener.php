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
    private $ssoFactory;

    public function __construct(SecurityContextInterface $securityContext, AuthenticationManagerInterface $authenticationManager, SessionAuthenticationStrategyInterface $sessionStrategy, HttpUtils $httpUtils, $providerKey, Factory $ssoFactory, array $options = array(), AuthenticationSuccessHandlerInterface $successHandler = null, AuthenticationFailureHandlerInterface $failureHandler = null, LoggerInterface $logger = null, EventDispatcherInterface $dispatcher = null)
    {
        parent::__construct($securityContext, $authenticationManager, $sessionStrategy, $httpUtils, $providerKey, $options, $successHandler, $failureHandler, $logger, $dispatcher);

        $this->ssoFactory = $ssoFactory;
    }

    protected function attemptAuthentication(Request $request)
    {
        $ssoProvider = $this->ssoFactory->createProvider($this->options['server'], $this->options['check_path']);

        if (!$ssoProvider->isValidationRequest($request)) {
            return null;
        }

        return $this->authenticationManager->authenticate($ssoProvider->createToken($request));
    }
}
