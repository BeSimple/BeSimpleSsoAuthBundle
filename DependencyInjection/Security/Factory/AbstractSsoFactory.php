<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

abstract class AbstractSsoFactory extends AbstractFactory
{
    public function create(ContainerBuilder $container, $id, $config, $userProviderId, $defaultEntryPointId)
    {
        $this->createLogoutSuccessHandler($container, $config);

        return parent::create($container, $id, $config, $userProviderId, $defaultEntryPointId);
    }

    public function getPosition()
    {
        return 'form';
    }

    protected function createAuthProvider(ContainerBuilder $container, $id, $config, $userProviderId)
    {
        $provider = 'security.authentication.provider.sso.'.$id;
        
        $container
            ->setDefinition($provider, new DefinitionDecorator('security.authentication.provider.sso'))
            ->replaceArgument(0, new Reference($userProviderId))
        ;

        return $provider;
    }

    protected function createLogoutSuccessHandler(ContainerBuilder $container, $config)
    {
        $templateHandler = 'security.logout.sso.success_handler';
        $realHandler     = 'security.logout.success_handler';

        // dont know if this is the right way, but it works
        $container
            ->setDefinition($realHandler, new DefinitionDecorator($templateHandler))
            ->addArgument($config)
        ;
    }
}
