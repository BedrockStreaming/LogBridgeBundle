<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher;

class Builder extends BaseMatcher
{
    private function getTypeManager(): Matcher\Status\TypeManager
    {
        $typeManager = new Matcher\Status\TypeManager();

        $typeManager->addType(new Matcher\Status\Type\SimpleType());
        $typeManager->addType(new Matcher\Status\Type\CompleteType());
        $typeManager->addType(new Matcher\Status\Type\RangeType());
        $typeManager->addType(new Matcher\Status\Type\UpperType());

        return $typeManager;
    }

    public function testBuilder(): void
    {
        $this
            ->given(
                $this->cacheClear(),
                $cacheDir = $this->getCacheDir(),
                $matcherClass = $this->getMatcherClassName(),
                $typeManager = $this->getTypeManager()
            )
            ->if($builder = new Matcher\Builder($typeManager, $this->getFilters(), $this->getActiveFilters()))
            ->then
                ->object($builder->setCacheDir($cacheDir))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Matcher\Builder::class)
                ->string($builder->getCacheDir())
                    ->isEqualTo($cacheDir)
                ->boolean($builder->isDebug(false))
                    ->isFalse()
                ->boolean($builder->isDebug(true))
                    ->isTrue()
                ->boolean($builder->isDebug())
                    ->isTrue()
                ->object($builder->setConfigParser($this->getParser()))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Matcher\Builder::class)
                ->object($builder->setMatcherClassName($matcherClass))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Matcher\Builder::class)
                ->string($builder->getMatcherClassName())
                    ->isEqualTo($matcherClass)
                ->string($builder->getAbsoluteCachePath())
                    ->contains($cacheDir)
                    ->contains($matcherClass)
                ->object($builder->getMatcher())
                    ->isInstanceOf($matcherClass)
        ;
    }
}
