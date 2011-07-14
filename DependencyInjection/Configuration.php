<?php

namespace BeSimple\SsoAuthBundle\DependencyInjection;

use Symfony\Component\Config\Definition\NodeInterface;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    private $debug;

    /**
     * @param Boolean $debug
     */
    public function  __construct($debug)
    {
        $this->debug = (Boolean) $debug;
    }

    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        
        $treeBuilder
            ->root('be_simple_sso_auth')
            ->fixXmlConfig('server')
            ->useAttributeAsKey('id')
            ->prototype('array')
                ->children()
                    ->scalarNode('protocol')->cannotBeEmpty()->end()
                    ->scalarNode('base_url')->cannotBeEmpty()->end()
                    ->scalarNode('version')->defaultValue(1)->end()
                    ->scalarNode('username')->defaultValue('{username}@{server_id}')->end()
                    ->arrayNode('validation_request')
                        ->addDefaultsIfNotSet()
                        ->children()
                            ->scalarNode('client')->defaultValue('FileGetContents')->end()
                            ->scalarNode('method')->defaultValue('get')->end()
                            ->scalarNode('timeout')->defaultValue(5)->end()
                            ->scalarNode('max_redirects')->defaultValue(5)->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
