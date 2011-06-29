<?php

namespace BeSimple\SsoAuthBundle\Security\Http\EntryPoint;

use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\HttpKernel;
use BeSimple\SsoAuthBundle\Sso\SsoFactory;

class TrustedSsoAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @var HttpKernel
     */
    protected $httpKernel;

    /**
     * @var SsoFactory
     */
    protected $ssoFactory;

    /**
     * @var array
     */
    protected $ssoConfig;

    /**
     * @param HttpKernel $httpKernel
     * @param SsoProviderFactory $ssoFactory
     * @param array $ssoConfig
     */
    public function __construct(HttpKernel $httpKernel, SsoFactory $ssoFactory, array $ssoConfig)
    {
        $this->httpKernel = $httpKernel;
        $this->ssoFactory = $ssoFactory;
        $this->ssoConfig  = $ssoConfig;
    }

    /**
     * @param Request $request
     * @param null|AuthenticationException $authException
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $controller = $this->ssoConfig['login_controller'];
        $provider   = $this->ssoFactory->createProvider($this->ssoConfig);

        if ($controller) {
            return $this->httpKernel->forward($controller, array(
                'provider'  => $provider,
                'request'   => $request,
                'exception' => $authException,
            ));
        }

        return new RedirectResponse($provider->getServer()->getLoginUri());
    }
}
