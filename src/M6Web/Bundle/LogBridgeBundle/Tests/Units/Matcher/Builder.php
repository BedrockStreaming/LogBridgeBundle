<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher;

class Builder extends BaseMatcher
{
    private function getTypeManager()
    {
        $typeManager = new Matcher\Status\TypeManager();

        $typeManager->addType(new Matcher\Status\Type\SimpleType());
        $typeManager->addType(new Matcher\Status\Type\CompleteType());
        $typeManager->addType(new Matcher\Status\Type\RangeType());
        $typeManager->addType(new Matcher\Status\Type\UpperType());

        return $typeManager;
    }

    public function testBuilder()
    {
        $this
            ->given(
                $this->cacheClear(),
                $cacheDir = $this->getCacheDir(),
                $matcherClass = $this->getMatcherClassName(),
                $typeManager = $this->getTypeManager()
            )
            ->if($builder = new Matcher\Builder($typeManager, [], 'test'))
            ->then
                ->object($builder->setCacheDir($cacheDir))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\Builder')
                ->string($builder->getCacheDir())
                    ->isEqualTo($cacheDir)
                ->object($builder->addResource($this->getResource()))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\Builder')
                ->object($builder->setResources([$this->getResource()]))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\Builder')
                ->array($builder->getResources())
                    ->hasSize(1)
                ->boolean($builder->isDebug(false))
                    ->isFalse()
                ->boolean($builder->isDebug(true))
                    ->isTrue()
                ->boolean($builder->isDebug())
                    ->isTrue()
                ->object($builder->setConfigParser($this->getParser()))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\Builder')
                ->object($builder->setMatcherClassName($matcherClass))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\Builder')
                ->string($builder->getMatcherClassName())
                    ->isEqualTo($matcherClass)
                ->string($builder->getAbsoluteCachePath())
                    ->contains($cacheDir)
                    ->contains($matcherClass)
                ->object($builder->getMatcher())
                    ->isInstanceOf($matcherClass)
                ->array($builder->getCacheResources())
                    ->hasSize(1)
                    ->isIdenticalTo($builder->getResources())
                    ->isIdenticalTo([$this->getResource()])
                ->object($builder->addCacheResource('config2.yml'))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\Builder')
                ->array($builder->getCacheResources())
                    ->hasSize(2)
        ;
    }

    public function testGetMatcherBadConfiguration()
    {
        $this
            ->given(
                $typeManager = $this->getTypeManager()
            )
            ->if($builder = new Matcher\Builder($typeManager, ['invalidFilename.yml'], 'test'))
            ->then
                ->exception(function() use ($builder) {
                    $builder->getMatcher();
                })
                    ->hasMessage('failed to open stream: No such file or is not readable "invalidFilename.yml"')
        ;
    }
}
