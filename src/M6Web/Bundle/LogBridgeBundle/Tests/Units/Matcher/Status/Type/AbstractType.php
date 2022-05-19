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

    public function testMatch(): void
    {
        $this
            ->given(
                $type = new TestedClass()
            )
            ->then
            ->boolean($type->match('350'))
                ->isTrue()
            ->boolean($type->match('3500'))
                ->isFalse()
            ->boolean($type->match('50'))
                ->isFalse()
            ->boolean($type->match('!350'))
                ->isTrue()
            ->boolean($type->match('!3500'))
                ->isFalse()
            ->boolean($type->match('!50'))
                ->isFalse()
        ;
    }

    public function testGetStatus(): void
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
                    $typeBadTransform->getStatus('200');
                }
            )
            ->hasCode(0)
            ->hasMessage('mock\M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type\Sample1Type::transform(): Return value must be of type array, string returned')
        ;
    }

    public function testIsExclude(): void
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
