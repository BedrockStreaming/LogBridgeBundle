<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher;



class MatcherProxy extends BaseMatcher
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

    public function testProxy()
    {
        $this
            ->if($proxy = new Matcher\MatcherProxy($this->getBuilder()))
            ->then
                ->object($proxy->getBuilder())
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\Builder')
                ->object($proxy->getMatcher())
                    ->isInstanceOf($this->getMatcherClassName())
                ->boolean($proxy->match('get_program', 'GET', 200))
                    ->isTrue()
                ->boolean($proxy->match('get_program', 'POST', 200))
                    ->isFalse()
                ->boolean($proxy->match('invalid_route', 'GET', 200))
                    ->isFalse()
        ;
    }

}
