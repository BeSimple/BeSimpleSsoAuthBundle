<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SsoFactory
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createProvider(array $config)
    {
        $provider = $this->container->get(sprintf('be_simple_sso_auth.sso_provider.%s', $config['protocol']));
        $checkUrl = $this->container->get('request')->getUriForPath($config['check_path']);

        $provider->configure($config['base_url'], $checkUrl, $config['version']);

        return $provider;
    }
}
