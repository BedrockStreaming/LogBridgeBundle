<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Dumper;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher;
use M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\BaseMatcher;

class PhpMatcherDumper extends BaseMatcher
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

    private function getBuilder()
    {
        $builder = new Matcher\Builder($this->getTypeManager(), $this->getFilters(), $this->getActiveFilters(), 'test');

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

                # get_clip_all_status
                ->boolean($dumper->match('get_clip', 'GET', 200))
                    ->isTrue()
                ->boolean($dumper->match('get_clip', 'PUT', 200))
                    ->isTrue()
                ->boolean($dumper->match('get_clip', 'DELETE', 200))
                    ->isFalse()

                # put_clip_form_all_200
                ->boolean($dumper->match('put_clips_form', 'GET', 200))
                    ->isFalse()
                ->boolean($dumper->match('put_clips_form', 'PUT', 200))
                    ->isTrue()
                ->boolean($dumper->match('put_clips_form', 'PUT', 240))
                   ->isTrue()
                ->boolean($dumper->match('put_clips_form', 'PUT', 258))
                    ->isTrue()

                # delete_clip_450_more_without_452_to_458
                ->boolean($dumper->match('delete_clip', 'DELETE', 449))
                    ->isFalse()
                ->boolean($dumper->match('delete_clip', 'DELETE', 450))
                    ->isTrue()
                ->boolean($dumper->match('delete_clip', 'DELETE', 451))
                    ->isTrue()
                ->boolean($dumper->match('delete_clip', 'DELETE', 452))
                    ->isFalse()
                ->boolean($dumper->match('delete_clip', 'DELETE', 458))
                    ->isFalse()
                ->boolean($dumper->match('delete_clip', 'DELETE', 459))
                    ->isTrue()
                ->boolean($dumper->match('delete_clip', 'DELETE', 499))
                    ->isTrue()

                # invalid_route
                ->boolean($dumper->match('invalid_route', 'GET', 200))
                    ->isFalse()
                ->string($dumper->generateFilterKey('get_program', 'GET', 200))
                    ->isEqualTo('get_program.GET.200')
        ;
    }
}
