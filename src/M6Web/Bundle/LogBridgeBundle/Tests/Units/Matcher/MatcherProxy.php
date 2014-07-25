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

    private function createFilters($matcher)
    {
        $key500 = $matcher->generateKey('dynamically_un', 'POST', 500);
        $key422 = $matcher->generateKey('dynamically_deux', 'PUT', 422);

        return [
            $key500 => ['content' => true],
            $key422 => ['content' => false ]
        ];
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

    public function testDynamicallyFilter()
    {
        $this
            ->if($proxy = new Matcher\MatcherProxy($this->getBuilder()))
            ->then
                ->object($proxy->getBuilder())
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\Builder')
                ->object($matcher = $proxy->getMatcher())
                    ->isInstanceOf($this->getMatcherClassName())
                ->boolean($proxy->match('get_program_dynamically', 'GET', 200))
                    ->isFalse()
                ->object($proxy->addFilter($matcher->generateKey('get_program_dynamically', 'GET', 200)))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\MatcherProxy')
                ->boolean($proxy->match('get_program_dynamically', 'GET', 200))
                    ->isTrue()
                ->object($proxy->setFilters($this->createFilters($matcher)))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\MatcherProxy')
                ->boolean($proxy->match('dynamically_un', 'POST', 500))
                    ->isTrue()
                ->boolean($proxy->match('dynamically_deux', 'PUT', 422))
                    ->isTrue()
                ->boolean($proxy->hasFilter($matcher->generateKey('get_program_dynamically', 'GET', 200)))
                    ->isTrue()
                ->boolean($proxy->hasFilter($matcher->generateKey('get_program_dynamically', 'GET', 500)))
                    ->isFalse()
                ->array($matcher->getFilters())
                    ->hasKey($matcher->generateKey('get_program', 'GET', 200))
                    ->hasKey($matcher->generateKey('get_program_dynamically', 'GET', 200))
                    ->hasKey($matcher->generateKey('dynamically_un', 'POST', 500))
        ;
    }

}
