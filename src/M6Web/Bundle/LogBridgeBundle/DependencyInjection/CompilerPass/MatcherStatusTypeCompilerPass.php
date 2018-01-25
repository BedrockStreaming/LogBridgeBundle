<?php

namespace M6Web\Bundle\LogBridgeBundle\DependencyInjection\CompilerPass;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class MatcherStatusTypeCompilerPass
 */
class MatcherStatusTypeCompilerPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        if (!$container->has('m6web_log_bridge.matcher.status.type_manager')) {
            return;
        }

        $typeManager = $container->findDefinition(
            'm6web_log_bridge.matcher.status.type_manager'
        );

        $types = $container->findTaggedServiceIds(
            'm6web_log_bridge.matcher_status_type'
        );

        foreach ($types as $id => $tags) {
            foreach ($tags as $attributes) {
                $typeManager->addMethodCall(
                    'addType',
                    [new Reference($id)]
                );
            }
        }
    }
}
