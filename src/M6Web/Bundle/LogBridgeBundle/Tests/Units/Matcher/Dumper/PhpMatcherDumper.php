<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Dumper;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher;
use M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\BaseMatcher;


class PhpMatcherDumper extends BaseMatcher
{

    private function getBuilder()
    {
        $builder = new Matcher\Builder([$this->getResource()], 'test');

        $builder
                ->setMatcherClassName($this->getMatcherClassName())
                ->setCacheDir($this->getCacheDir())
                ->setConfigParser($this->getParser());

        return $builder;
    }

    public function testDumper()
    {
        $this
            ->if($builder = $this->getBuilder())
            ->then
                ->object($dumper = $builder->getMatcher())
                    ->isInstanceOf($this->getMatcherClassName())
                ->boolean($dumper->match('get_program', 'GET', 200))
                    ->isTrue()
                ->boolean($dumper->match('get_program', 'POST', 200))
                    ->isFalse()
                ->boolean($dumper->match('invalid_route', 'GET', 200))
                    ->isFalse()
                ->string($dumper->generateKey('get_program', 'GET', 200))
                    ->isEqualTo('get_program.GET.200')
        ;
    }

}
