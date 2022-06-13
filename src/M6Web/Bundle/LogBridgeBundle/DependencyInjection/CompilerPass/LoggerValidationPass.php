<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

/**
 * Validates logger service used by the log request listener.
 */
class LoggerValidationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container): void
    {
        if (!$container->hasParameter('m6web_log_bridge.logger.service')) {
            return;
        }

        $loggerServiceId = $container->getParameter('m6web_log_bridge.logger.service');
        $loggerClass = $container->findDefinition($loggerServiceId)->getClass();

        // If $loggerClass is not a valid namespace but a container parameter
        if (preg_match("/^%[\w\.]+%$/", $loggerClass)) {
            $loggerClassParameter = substr($loggerClass, 1, -1);
            $loggerClass = $container->getParameter($loggerClassParameter);
        }

        if (!in_array(\Psr\Log\LoggerInterface::class, class_implements($loggerClass), true)) {
            throw new \InvalidArgumentException(sprintf('Class "%s" must be implement "Psr\Log\LoggerInterface"', $loggerClass));
        }
    }
}
