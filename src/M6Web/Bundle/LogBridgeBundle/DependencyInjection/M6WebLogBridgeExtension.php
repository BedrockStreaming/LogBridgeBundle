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
        $config        = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__ . '/../Resources/config'));
        $loader->load('services.yml');

        $container->setParameter('m6web_log_bridge.logger.service', $config['logger']['service']);
        $container->setParameter('m6web_log_bridge.logger.channel', $config['logger']['channel']);
        $container->setParameter('m6web_log_bridge.resources', $config['resources']);
        $container->setParameter('m6web_log_bridge.prefix_key', $config['prefix_key']);
        $container->setParameter('m6web_log_bridge.content_formatter', $config['content_formatter']);
        $container->setParameter('m6web_log_bridge.exception.request_attribute', $config['exception']['request_attribute']);

        if ($config['exception']['log']) {
            $this->loadExceptionListener($container);
        }

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

        $this->validateLogger($container, $config['logger']);
        $this->loadRequestListener($container);
    }

    /**
     * validateLogger
     *
     * @param ContainerBuilder $container    Container
     * @param array            $loggerConfig Logger configuration
     *
     * @throws \Exception Class logger must be implement "Psr\Log\LoggerInterface"
     *
     * @return bool
     */
    protected function validateLogger(ContainerBuilder $container, $loggerConfig)
    {
        $loggerClass = $container->getDefinition($loggerConfig['service'])->getClass();

        // If $loggerClass is not a valid namespace but a container parameter
        if (preg_match("/^%[\w\.]+%$/", $loggerClass)) {
            $loggerClassParameter = substr($loggerClass, 1, -1);
            $loggerClass = $container->getParameter($loggerClassParameter);
        }

        if (!in_array('Psr\Log\LoggerInterface', class_implements($loggerClass))) {
            throw new \Exception(sprintf('Class "%s" must be implement "Psr\Log\LoggerInterface"', $loggerClass));
        }

        return true;
    }

    /**
     * loadRequestListener
     *
     * @param ContainerBuilder $container Container
     */
    protected function loadRequestListener(ContainerBuilder $container)
    {
        $className          = $container->getParameter('m6web_log_bridge.log_request_listener.class');
        $serviceName        = $container->getParameter('m6web_log_bridge.log_request_listener.name');
        $matcherServiceName = $container->getParameter('m6web_log_bridge.matcher.name');
        $contentFormatter   = $container->getParameter('m6web_log_bridge.content_formatter');
        $loggerServiceName  = $container->getParameter('m6web_log_bridge.logger.service');

        $definition = new Definition($className);

        $definition
            ->addArgument(new Reference($contentFormatter))
            ->addMethodCall('setLogger', [new Reference($loggerServiceName)])
            ->addMethodCall('setMatcher', [new Reference($matcherServiceName)])
            ->addTag(
                'kernel.event_listener',
                [
                    'event'  => 'kernel.response',
                    'method' => 'onKernelTerminate'
                ]
            );

        $container->setDefinition($serviceName, $definition);
    }

    /**
     * loadExceptionListener
     *
     * @param ContainerBuilder $container Container
     */
    protected function loadExceptionListener(ContainerBuilder $container)
    {
        $className                 = $container->getParameter('m6web_log_bridge.log_exception_listener.class');
        $serviceName               = $container->getParameter('m6web_log_bridge.log_exception_listener.name');
        $requestExceptionAttribute = $container->getParameter('m6web_log_bridge.exception.request_attribute');

        $definition = new Definition($className);

        $definition
            ->addArgument($requestExceptionAttribute)
            ->addTag(
                'kernel.event_listener',
                [
                    'event'  => 'kernel.exception',
                    'method' => 'onKernelException'
                ]
            );

        $container->setDefinition($serviceName, $definition);
    }
}
