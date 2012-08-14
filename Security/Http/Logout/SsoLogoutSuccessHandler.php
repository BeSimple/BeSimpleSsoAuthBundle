<?php

namespace BeSimple\SsoAuthBundle\Security\Http\Logout;

use Symfony\Component\Security\Http\Logout\LogoutSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\HttpKernel;
use BeSimple\SsoAuthBundle\Sso\Factory;

class SsoLogoutSuccessHandler implements LogoutSuccessHandlerInterface
{
    /**
     * @var HttpKernel
     */
    protected $httpKernel;

    /**
     * @var Factory
     */
    protected $factory;

    /**
     * @var array
     */
    protected $config;

    /**
     * @param HttpKernel $httpKernel
     * @param Factory    $factory
     * @param array      $config
     */
    public function __construct(HttpKernel $httpKernel, Factory $factory, array $config)
    {
        $this->httpKernel = $httpKernel;
        $this->factory    = $factory;
        $this->config     = $config;
    }

    /**
     * @param Request $request
     *
     * @return Response
     */
    public function onLogoutSuccess(Request $request)
    {
        $action  = $this->config['logout_action'];
        $manager = $this->factory->getManager($this->config['manager'], $request->getUriForPath($this->config['check_path']));

        if ($action) {
            return $this->httpKernel->forward($action, array(
                'manager' => $manager,
                'request' => $request,
            ));
        }

        return new RedirectResponse($manager->getServer()->getLogoutUrl());
    }
}
