<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher;

class Builder extends BaseMatcher
{
    public function testBuilder()
    {
        $cacheDir     = $this->getCacheDir();
        $matcherClass = $this->getMatcherClassName();

        $this
            ->if($builder = new Matcher\Builder([]))
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

}
