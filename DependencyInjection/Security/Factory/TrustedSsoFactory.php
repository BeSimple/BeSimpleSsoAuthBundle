<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection\Security\Factory;

use Symfony\Component\DependencyInjection\DefinitionDecorator;
use Symfony\Component\DependencyInjection\Reference;

/**
 * @author: Jean-François Simon <contact@jfsimon.fr>
 */
class TrustedSsoFactory extends AbstractSsoFactory
{
    public function __construct()
    {
        parent::__construct();

        $this->addOption('manager');
    }

    public function getKey()
    {
        return 'trusted_sso';
    }

    protected function getListenerId()
    {
        return 'security.authentication.listener.trusted_sso';
    }

    protected function createEntryPoint($container, $id, $config, $defaultEntryPoint)
    {
        $entryPointId = 'security.authentication.trusted_sso_entry_point.'.$id;

        $container
            ->setDefinition($entryPointId, new DefinitionDecorator('security.authentication.trusted_sso_entry_point'))
            ->addArgument($config)
        ;

        return $entryPointId;
    }

    protected function createListener($container, $id, $config, $userProvider)
    {
        $listenerId = $this->getListenerId();
        $listener   = new DefinitionDecorator($listenerId);

        $listener->replaceArgument(4, $id);
        $listener->replaceArgument(6, array_intersect_key($config, $this->options));

        // success handler
        if (isset($config['success_handler'])) {
            $listener->replaceArgument(7, new Reference($config['success_handler']));
        }

        // failure handler
        if (isset($config['failure_handler'])) {
            $listener->replaceArgument(8, new Reference($config['failure_handler']));
        }

        $listenerId .= '.'.$id;
        $container->setDefinition($listenerId, $listener);

        return $listenerId;
    }
}
