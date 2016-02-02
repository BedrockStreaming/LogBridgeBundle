<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status\Type;

use atoum\AtoumBundle\Test\Units;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\RangeType as TestedClass;

class RangeType extends Units\Test
{
    /**
     * Test get status
     *
     * @dataProvider dataTestGetStatus
     *
     * @param string $config
     * @param array  $statusResult
     */
    public function testGetStatus($config, $statusResult)
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
    public function dataTestGetStatus()
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