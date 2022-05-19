<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\EventDispatcher;

use atoum;
use M6Web\Bundle\LogBridgeBundle\EventDispatcher\BuilderEvent as TestedClass;

class BuilderEvent extends atoum
{
    public function testBuildEventIsInstanciable(): void
    {
        $this
            ->given($this->mockGenerator->orphanize('__construct'))
            ->if($this->newTestedInstance(
                new \mock\M6Web\Bundle\LogBridgeBundle\Matcher\BuilderInterface,
                []
            ))
            ->then
                ->object($this->testedInstance)
                    ->isInstanceOf(TestedClass::class)
        ;
    }
}
