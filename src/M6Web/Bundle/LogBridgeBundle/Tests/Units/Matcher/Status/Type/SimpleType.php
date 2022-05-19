<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status\Type;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\SimpleType as TestedClass;

class SimpleType extends atoum
{
    /**
     * Test get status
     *
     * @dataProvider dataTestGetStatus
     */
    public function testGetStatus(string $config, array $statusResult): void
    {
        $this
            ->given(
                $type = new TestedClass()
            )
            ->then
            ->array($type->getStatus($config))
                ->isEqualTo($statusResult)
        ;
    }

    /**
     * Data to testGetStatus
     */
    public function dataTestGetStatus(): array
    {
        return [
            [
                '550',
                [550]
            ],
            [
                '200',
                [200]
            ],
            [
                '!550',
                [550]
            ],
            [
                '!200',
                [200]
            ],
        ];
    }
}
