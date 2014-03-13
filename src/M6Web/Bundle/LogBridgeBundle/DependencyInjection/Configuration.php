<?php

namespace M6Web\Bundle\LogBridgeBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode    = $treeBuilder->root('m6_web_log_bridge');

        $rootNode
                ->children()
                    ->scalarNode('prefix_key')
                        ->defaultValue('')
                    ->end()
                    ->scalarNode('logger')
                        ->isRequired()
                    ->end()
                    ->arrayNode('resources')
                        ->prototype('scalar')
                        ->isRequired()
                    ->end()
                ->end();

        return $treeBuilder;
    }

}
