<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection\Security\Factory;

use Symfony\Bundle\SecurityBundle\DependencyInjection\Security\Factory\AbstractFactory;
use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
abstract class AbstractSsoFactory extends AbstractFactory
{
    public function __construct()
    {
        $this->addOption('create_users', false);
        $this->addOption('created_users_roles', array('ROLE_USER'));
        $this->addOption('login_action', 'BeSimpleSsoAuthBundle:TrustedSso:login');
        $this->addOption('logout_action', 'BeSimpleSsoAuthBundle:TrustedSso:logout');
    }

    public function create(ContainerBuilder $container, $id, $config, $userProviderId, $defaultEntryPointId)
    {
        $this->createLogoutSuccessHandler($container, $id, $config);

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
            ->replaceArgument(2, $config['create_users'])
            ->replaceArgument(3, $config['created_users_roles'])
        ;

        return $provider;
    }

    public function addConfiguration(NodeDefinition $node)
    {
        parent::addConfiguration($node);

        $node
            ->children()
                ->arrayNode('created_users_roles')
                    ->prototype('scalar')->end()
                ->end()
            ->end()
        ;
    }

    protected function createLogoutSuccessHandler(ContainerBuilder $container, $id, $config)
    {
        $templateHandler = 'security.logout.sso.success_handler';
        $realHandler     = 'security.logout.success_handler';

        // don't know if this is the right way, but it works
        $container
            ->setDefinition($realHandler.'.'.$id, new DefinitionDecorator($templateHandler))
            ->addArgument($config)
        ;
    }
}
