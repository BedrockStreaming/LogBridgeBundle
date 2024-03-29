<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status\Type;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\RangeType as TestedClass;

class RangeType extends atoum
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
                '540-550',
                range(540, 550)
            ],
            [
                '248-296',
                range(248, 296)
            ],
            [
                '!540-550',
                range(540, 550)
            ],
            [
                '!248-296',
                range(248, 296)
            ],
        ];
    }
}
