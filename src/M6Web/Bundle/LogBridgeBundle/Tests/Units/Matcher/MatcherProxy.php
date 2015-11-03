<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher;

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
        $keyNoConfig = $matcher->generateFilterKey('dynamically_no_config', 'GET', 200);
        $key500      = $matcher->generateFilterKey('dynamically_un', 'POST', 500);
        $key422      = $matcher->generateFilterKey('dynamically_deux', 'PUT', 422);

        return [
            $keyNoConfig => [],
            $key500 => [
                'level'   => 'error',
                'options' => ['response_body' => true]
            ],
            $key422 => [
                'level'   => 'warning',
                'options' => ['response_body' => false]
            ],
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
                ->object($proxy->addFilter($matcher->generateFilterKey('get_program_dynamically', 'GET', 200)))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\MatcherProxy')
                ->boolean($proxy->match('get_program_dynamically', 'GET', 200))
                    ->isTrue()
                ->object($proxy->setFilters($this->createFilters($matcher)))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Matcher\MatcherProxy')
                ->boolean($proxy->match('dynamically_un', 'POST', 500))
                    ->isTrue()
                ->boolean($proxy->match('dynamically_deux', 'PUT', 422))
                    ->isTrue()
                ->boolean($proxy->hasFilter($matcher->generateFilterKey('get_program_dynamically', 'GET', 200)))
                    ->isTrue()
                ->boolean($proxy->hasFilter($matcher->generateFilterKey('get_program_dynamically', 'GET', 500)))
                    ->isFalse()
                ->array($filters = $matcher->getFilters())
                    ->hasKey($matcher->generateFilterKey('get_program', 'GET', 200))
                    ->hasKey($matcher->generateFilterKey('get_program_dynamically', 'GET', 200))
                    ->hasKey($matcher->generateFilterKey('dynamically_un', 'POST', 500))
        ;
    }
}
