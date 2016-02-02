<?php

namespace M6Web\Bundle\LogBridgeBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use M6Web\Bundle\LogBridgeBundle\DependencyInjection\CompilerPass\MatcherStatusTypeCompilerPass;

/**
 * Class M6WebLogBridgeBundle
 *
 * @package M6Web\Bundle\LogBridgeBundle
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
    }
}
