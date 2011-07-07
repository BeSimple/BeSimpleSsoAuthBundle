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
        $defaultValidationRequest = array(
            'client'        => 'FileGetContents',
            'method'        => 'get',
            'timeout'       => 5,
            'max_redirects' => 5
        );

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
                    ->scalarNode('username')->defaultValue('{username}@{base_url}')->end()
                    ->arrayNode('validation_request')
                        ->defaultValue($defaultValidationRequest)
                        ->children()
                            ->scalarNode('client')->defaultValue($defaultValidationRequest['client'])->end()
                            ->scalarNode('method')->defaultValue($defaultValidationRequest['method'])->end()
                            ->scalarNode('timeout')->defaultValue($defaultValidationRequest['timeout'])->end()
                            ->scalarNode('max_redirects')->defaultValue($defaultValidationRequest['max_redirects'])->end()
                        ->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
