<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\DefinitionDecorator;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class OpenSsoFactory extends AbstractSsoFactory
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getKey()
    {
        return 'open_sso';
    }

    protected function getListenerId()
    {
        return 'security.authentication.listener.open_sso';
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
    {
        $entryPointId = 'security.authentication.open_sso_entry_point.'.$id;

        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('security.authentication.open_sso_entry_point'))
            ->addArgument($config)
        ;

        return $entryPointId;
    }

    protected function createListener($container, $id, $config, $userProvider)
    {
        $listenerId = parent::createListener($container, $id, $config, $userProvider);

        $container
            ->getDefinition($listenerId)
            ->replaceArgument(5, $config)
        ;

        return $listenerId;
    }
}
