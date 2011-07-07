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

    public function createProvider($serverName, $checkPath)
    {
        $config   = $this->getServerConfig($serverName);
        $provider = $this->container->get(sprintf('be_simple_sso_auth.sso_provider.%s', $config['protocol']));
        $checkUrl = $this->container->get('request')->getUriForPath($checkPath);

        $provider
            ->getServer()
            ->setBaseUrl($config['base_url'])
            ->setCheckUrl($checkUrl)
            ->setVersion($config['version'])
            ->setValidationMethod($config['validation_request']['method'])
            ->setValidationClient($this->getValidationClient($config['validation_request']))
            ->setUsernameFormat($config['username'])
        ;

        return $provider;
    }

    private function getServerConfig($serverName)
    {
        if ($this->container->hasParameter('be_simple_sso_auth.default_config')) {
            return array_merge_recursive(
                $this->container->getParameter('be_simple_sso_auth.default_config', array()),
                $this->container->getParameter(sprintf('be_simple_sso_auth.%s_config', $serverName))
            );
        }

        return $this->container->getParameter(sprintf('be_simple_sso_auth.%s_config', $serverName));
    }

    private function getValidationClient(array $config)
    {
        $class  = sprintf('Buzz\\Client\\%s', $config['client']);
        $client = new $class();

        $client->setTimeout($config['timeout']);
        $client->setMaxRedirects($config['max_redirects']);

        return $client;
    }
}
