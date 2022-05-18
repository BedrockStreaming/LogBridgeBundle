<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle;

use M6Web\Bundle\LogBridgeBundle\DependencyInjection\CompilerPass\LoggerValidationPass;
use M6Web\Bundle\LogBridgeBundle\DependencyInjection\CompilerPass\MatcherStatusTypeCompilerPass;
use Symfony\Component\DependencyInjection\Compiler\PassConfig;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class M6WebLogBridgeBundle
 */
class M6WebLogBridgeBundle extends Bundle
{
    /**
     * Build bundle
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new MatcherStatusTypeCompilerPass());
        $container->addCompilerPass(new LoggerValidationPass(), PassConfig::TYPE_OPTIMIZE);
    }
}
