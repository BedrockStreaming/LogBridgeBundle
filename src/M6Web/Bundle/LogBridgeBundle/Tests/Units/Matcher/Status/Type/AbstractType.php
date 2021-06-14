<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status\Type;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type\Sample1Type as TestedClass;

class AbstractType extends atoum
{
    public function getSample1TypeMock()
    {
        $this->mockGenerator->orphanize('__construct');
        $sample1Type = new \mock\M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type\Sample1Type();

        $sample1Type->getMockController()->transform = 'invalid_format';

        return $sample1Type;
    }

    public function testMatch()
    {
        $this
            ->given(
                $type = new TestedClass()
            )
            ->then
            ->integer($type->match('350'))
                ->isEqualTo(1)
            ->integer($type->match('3500'))
                ->isEqualTo(0)
            ->integer($type->match('50'))
                ->isEqualTo(0)
            ->integer($type->match('!350'))
                ->isEqualTo(1)
            ->integer($type->match('!3500'))
                ->isEqualTo(0)
            ->integer($type->match('!50'))
                ->isEqualTo(0)
        ;
    }

    public function testGetStatus()
    {
        $this
            ->given(
                $type = new TestedClass(),
                $typeBadTransform = $this->getSample1TypeMock()
            )
            ->then
            ->array($type->getStatus('200'))
                ->isEqualTo(['200'])
            ->array($type->getStatus('!200'))
                ->isEqualTo(['200'])
            ->exception(
                function () use ($typeBadTransform) {
                    $status = $typeBadTransform->getStatus('200');
                }
            )
            ->hasCode(500)
            ->hasMessage('"transform" method must be return an array in class "mock\M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type\Sample1Type"')
        ;
    }

    public function testIsExclude()
    {
        $this
            ->given(
                $type = new TestedClass()
            )
            ->then
            ->boolean($type->isExclude('200'))
                ->isFalse()
            ->boolean($type->isExclude('!200'))
                ->isTrue()
        ;
    }
}
