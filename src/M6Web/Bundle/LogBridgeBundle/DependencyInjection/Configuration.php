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
        $rootNode    = $treeBuilder->root('m6web_log_bridge');

        $rootNode
            ->children()
                ->scalarNode('prefix_key')
                    ->defaultValue('')
                ->end()
                ->arrayNode('logger')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->scalarNode('service')->defaultValue('m6web_log_bridge.logger')->end()
                        ->scalarNode('channel')->defaultValue('log_bridge')->end()
                    ->end()
                ->end()
                ->arrayNode('resources')
                    ->prototype('scalar')
                        ->isRequired()
                    ->end()
                ->end()
                ->scalarNode('content_formatter')
                    ->defaultValue('m6web_log_bridge.log_content_formatter')
                ->end()
                ->arrayNode('exception')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->booleanNode('log')->defaultValue(false)->end()
                        ->scalarNode('request_attribute')->defaultValue('LogBridgeException')->end()
                    ->end()
                ->end()
                ->arrayNode('ignore_headers')
                    ->prototype('scalar')
                        ->defaultValue(array())
                    ->end()
                ->end()

                ->arrayNode('filters')
                    ->children()
                        ->arrayNode('requests')
                            ->children()
                                ->scalarNode('route')->defaultNull()->end()
                                ->scalarNode('method')->defaultNull()->end()
                                ->arrayNode('status')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->scalarNode('level')->defaultNull()->end()
                                ->arrayNode('options')
                                    ->children()
                                        ->booleanNode('post_parameters')->defaultFalse()->end()
                                        ->booleanNode('response_body')->defaultFalse()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('bad_requests')
                            ->children()
                                ->scalarNode('route')->defaultNull()->end()
                                ->scalarNode('method')->defaultNull()->end()
                                ->arrayNode('status')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->scalarNode('level')->defaultNull()->end()
                                ->arrayNode('options')
                                    ->children()
                                        ->booleanNode('post_parameters')->defaultFalse()->end()
                                        ->booleanNode('response_body')->defaultFalse()->end()
                                ->end()
                                ->end()
                            ->end()
                        ->end()

                        ->arrayNode('bad_token')
                            ->children()
                                ->scalarNode('route')->defaultNull()->end()
                                ->scalarNode('method')->defaultNull()->end()
                                ->arrayNode('status')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->scalarNode('level')->defaultNull()->end()
                                ->arrayNode('options')
                                    ->children()
                                        ->booleanNode('post_parameters')->defaultFalse()->end()
                                        ->booleanNode('response_body')->defaultFalse()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                        ->arrayNode('errors')
                            ->children()
                                ->scalarNode('route')->defaultNull()->end()
                                ->scalarNode('method')->defaultNull()->end()
                                ->arrayNode('status')
                                    ->prototype('scalar')->end()
                                ->end()
                                ->scalarNode('level')->defaultNull()->end()
                                ->arrayNode('options')
                                    ->children()
                                        ->booleanNode('post_parameters')->defaultFalse()->end()
                                        ->booleanNode('response_body')->defaultFalse()->end()
                                    ->end()
                                ->end()
                            ->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('active_filters')
                    ->prototype('scalar')->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

}
