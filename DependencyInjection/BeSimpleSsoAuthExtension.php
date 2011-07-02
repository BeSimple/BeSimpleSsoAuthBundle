<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;

class BeSimpleSsoAuthExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $loader    = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $processor = new Processor();
        $config    = $processor->processConfiguration(new Configuration($container->getParameter('kernel.debug')), $config);

        var_dump($config); die;

        foreach ($config as $serverName => $serverConfig) {
            $container->setParameter(sprintf('be_simple_sso_auth.%s_config', $serverName), $serverConfig);
        }

        $loader->load('sso_providers.xml');
        $loader->load('security_listeners.xml');
    }
}
