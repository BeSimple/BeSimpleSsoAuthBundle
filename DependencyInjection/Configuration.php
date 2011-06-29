<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\NodeInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return NodeInterface
     */
    public function getConfigTree()
    {
        $treeBuilder = new TreeBuilder();

        $treeBuilder
            ->root('be_simple_sso_auth')
            ->children()
//                ->scalarNode('request_client')->defaultValue('curl')->end()
//                ->scalarNode('request_timeout')->defaultValue(5)->end()
//                ->scalarNode('request_max_redirects')->defaultValue(5)->end()
            ->end()
        ;

        return $treeBuilder->buildTree();
    }
}
