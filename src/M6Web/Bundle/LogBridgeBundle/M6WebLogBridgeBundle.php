<?php

namespace M6Web\Bundle\LogBridgeBundle;

use M6Web\Bundle\LogBridgeBundle\DependencyInjection\CompilerPass\LoggerValidationPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use M6Web\Bundle\LogBridgeBundle\DependencyInjection\CompilerPass\MatcherStatusTypeCompilerPass;

/**
 * Class M6WebLogBridgeBundle
 */
class M6WebLogBridgeBundle extends Bundle
{
    /**
     * Build bundle
     *
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MatcherStatusTypeCompilerPass());
        $container->addCompilerPass(new LoggerValidationPass(), PassConfig::TYPE_OPTIMIZE);
    }
}
