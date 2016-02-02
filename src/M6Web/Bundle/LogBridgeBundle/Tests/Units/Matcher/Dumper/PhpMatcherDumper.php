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
        $builder = new Matcher\Builder($this->getTypeManager(), [$this->getResource()], 'test');

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

                # delete_clip_500_all_hundred_without_580_to_590
                ->boolean($dumper->match('delete_clip', 'DELETE', 501))
                    ->isTrue()
                ->boolean($dumper->match('delete_clip', 'DELETE', 510))
                    ->isTrue()
                ->boolean($dumper->match('delete_clip', 'DELETE', 580))
                    ->isFalse()
                ->boolean($dumper->match('delete_clip', 'DELETE', 589))
                    ->isFalse()
                ->boolean($dumper->match('delete_clip', 'DELETE', 590))
                    ->isTrue()

                # edit_clip_5*_30*_without_550_549
                ->boolean($dumper->match('edit_clip', 'PATH', 501))
                    ->isTrue()
                ->boolean($dumper->match('edit_clip', 'PATH', 510))
                    ->isTrue()
                ->boolean($dumper->match('edit_clip', 'PATH', 550))
                    ->isFalse()
                ->boolean($dumper->match('edit_clip', 'PATH', 549))
                    ->isFalse()
                ->boolean($dumper->match('edit_clip', 'PATH', 301))
                    ->isTrue()
                ->boolean($dumper->match('edit_clip', 'PATH', 309))
                    ->isTrue()
                ->boolean($dumper->match('edit_clip', 'PATH', 310))
                    ->isFalse()
                ->boolean($dumper->match('edit_clip', 'PATH', 325))
                    ->isFalse()

                # edit_clip_404_to_410
                ->boolean($dumper->match('edit_clip', 'POST', 401))
                    ->isFalse()
                ->boolean($dumper->match('edit_clip', 'POST', 404))
                    ->isTrue()
                ->boolean($dumper->match('edit_clip', 'POST', 410))
                    ->isTrue()
                ->boolean($dumper->match('edit_clip', 'POST', 411))
                    ->isFalse()

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

                # get_program
                ->boolean($dumper->match('get_program', 'GET', 200))
                    ->isTrue()
                ->boolean($dumper->match('get_program', 'GET', 289))
                    ->isTrue()
                ->boolean($dumper->match('get_program', 'GET', 290))
                    ->isFalse()
                ->boolean($dumper->match('get_program', 'GET', 294))
                    ->isFalse()
                ->boolean($dumper->match('get_program', 'POST', 200))
                    ->isFalse()

                # invalid_route
                ->boolean($dumper->match('invalid_route', 'GET', 200))
                    ->isFalse()
                ->string($dumper->generateFilterKey('get_program', 'GET', 200))
                    ->isEqualTo('get_program.GET.200')
        ;
    }
}
