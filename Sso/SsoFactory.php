<?php

namespace BeSimple\SsoAuthBundle\Sso;

use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Buzz\Client\ClientInterface;

class SsoFactory
{
    private $container;
    
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function createProvider($serverName, $returnPath)
    {
        $config    = $this->getServerConfig($serverName);
        $provider  = $this->container->get(sprintf('be_simple_sso_auth.sso_provider.%s', $config['protocol']));
        $returnUrl = $this->container->get('request')->getUriForPath($returnPath);

        $provider
            ->getServer()
            ->setBaseUrl($config['base_url'])
            ->setReturnUrl($returnUrl)
            ->setVersion($config['version'])
            ->setValidationMethod($config['validation_request']['method'])
            ->setValidationClient($this->getValidationClient($config['validation_request']))
            ->setUsernameFormat($config['username'])
        ;

        return $provider;
    }

    private function getServerConfig($serverName)
    {
        return $this->container->getParameter(sprintf('be_simple_sso_auth.%s_config', $serverName));
    }

    private function getValidationClient(array $config)
    {
        $class  = strpos($config['client'], '\\') ? $config['client'] : sprintf('Buzz\\Client\\%s', $config['client']);
        $client = new $class();

        $client->setTimeout($config['timeout']);
        $client->setMaxRedirects($config['max_redirects']);

        return $client;
    }
}
