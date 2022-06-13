<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status\Type;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\UpperType as TestedClass;

class UpperType extends atoum
{
    /**
     * Test get status
     *
     * @dataProvider dataTestGetStatus
     */
    public function testGetStatus(string $config, array $statusResult)
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
                '^510',
                range(510, 599)
            ],
            [
                '^589',
                range(589, 599)
            ],
            [
                '!^510',
                range(510, 599)
            ],
            [
                '!^589',
                range(589, 599)
            ],
        ];
    }
}
