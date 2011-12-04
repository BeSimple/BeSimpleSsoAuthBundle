<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\Definition\Processor;
use Symfony\Component\Config\FileLocator;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class BeSimpleSsoAuthExtension extends Extension
{
    public function load(array $config, ContainerBuilder $container)
    {
        $processor = new Processor();
        $providers = $processor->processConfiguration(new Configuration($container->getParameter('kernel.debug')), $config);

        foreach ($providers as $id => $provider) {
            $container->setParameter(sprintf('be_simple.sso_auth.manager.%s', $id), $provider);
        }

        $loader = new XmlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('security_listeners.xml');
        $loader->load('factory.xml');
        $loader->load('cas.xml');
    }
}
