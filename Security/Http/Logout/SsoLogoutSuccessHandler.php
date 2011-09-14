<?php

namespace BeSimple\SsoAuthBundle\Security\Http\Logout;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\HttpKernel;
use BeSimple\SsoAuthBundle\Sso\SsoFactory;

class SsoLogoutSuccessHandler implements LogoutSuccessHandlerInterface
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
    protected $config;

    /**
     * @param HttpKernel $httpKernel
     * @param SsoProviderFactory $ssoFactory
     * @param array $ssoConfig
     */
    public function __construct(HttpKernel $httpKernel, SsoFactory $ssoFactory, array $config)
    {
        $this->httpKernel = $httpKernel;
        $this->ssoFactory = $ssoFactory;
        $this->config     = $config;
    }

    /**
     * @param Request $request
     * @param null|AuthenticationException $authException
     * @return Response
     */
    public function onLogoutSuccess(Request $request)
    {
        $action   = $this->config['logout_action'];
        $provider = $this->ssoFactory->createProvider($this->config['server'], $this->config['check_path']);

        if ($action) {
            return $this->httpKernel->forward($action, array(
                'provider' => $provider,
                'request'  => $request,
            ));
        }

        return $provider->handleLogout();
    }
}
