<?php

namespace M6Web\Bundle\LogBridgeBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class M6WebLogBridgeExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('m6web_log_bridge.logger_service', $config['logger']);
        $container->setParameter('m6web_log_bridge.resources', $config['resources']);
        $container->setParameter('m6web_log_bridge.prefix_key', $config['prefix_key']);
        $container->setParameter('m6web_log_bridge.content_formatter', $config['content_formatter']);

        if (!empty($config['ignore_headers'])) {
            $container
                    ->setParameter(
                        'm6web_log_bridge.ignore_headers',
                        array_merge(
                            $container->getParameter('m6web_log_bridge.ignore_headers'),
                            $config['ignore_headers']
                        )
                    );
        }

        $this->loadListener($container);
    }

    /**
     * loadListener
     *
     * @param ContainerBuilder $container Container
     */
    protected function loadListener(ContainerBuilder $container)
    {
        $className          = $container->getParameter('m6web_log_bridge.log_request_listener.class');
        $serviceName        = $container->getParameter('m6web_log_bridge.log_request_listener.name');
        $matcherServiceName = $container->getParameter('m6web_log_bridge.matcher.name');
        $contentFormatter   = $container->getParameter('m6web_log_bridge.content_formatter');
        $loggerName         = $container->getParameter('m6web_log_bridge.logger_service');
        $definition         = new Definition($className);

        $definition
                    ->addArgument(new Reference($contentFormatter))
                    ->addMethodCall('setLogger', [new Reference($loggerName)])
                    ->addMethodCall('setMatcher', [new Reference($matcherServiceName)])
                    ->addTag('kernel.event_listener', [
                        'event'  => 'kernel.response',
                        'method' => 'onKernelTerminate'
                    ]);

        $container->setDefinition($serviceName, $definition);
    }
}
