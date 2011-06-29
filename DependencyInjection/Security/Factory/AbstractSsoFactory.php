<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

abstract class AbstractSsoFactory extends AbstractFactory
{
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
//            ->replaceArgument(2, $id) // dont need provider id
        ;

        return $provider;
    }
}
