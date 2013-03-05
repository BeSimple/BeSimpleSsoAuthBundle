<?php

namespace BeSimple\SsoAuthBundle\Security\Http\EntryPoint;

use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use BeSimple\SsoAuthBundle\Sso\Factory;

class TrustedSsoAuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @var HttpKernel
     */
    protected $httpKernel;

    /**
     * @var SsoFactory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param HttpKernel $httpKernel
     * @param SsoProviderFactory $ssoFactory
     * @param array $config
     */
    public function __construct(HttpKernelInterface $httpKernel, Factory $factory, array $config)
    {
        $this->httpKernel = $httpKernel;
        $this->factory    = $factory;
        $this->config     = $config;
    }

    /**
     * @param Request $request
     * @param null|AuthenticationException $authException
     * @return Response
     */
    public function start(Request $request, AuthenticationException $authException = null)
    {
        $action  = $this->config['login_action'];
        $manager = $this->factory->getManager($this->config['manager'], $request->getUriForPath($this->config['check_path']));

        if ($action) {
            $subRequest = $request->duplicate(null, null, array(
                '_controller' => $action,
                'manager'   => $manager,
                'request'   => $request,
                'exception' => $authException,
            ));
            return $this->httpKernel->handle($subRequest, HttpKernelInterface::SUB_REQUEST);
        }

        return new RedirectResponse($manager->getServer()->getLoginUrl());
    }
}
