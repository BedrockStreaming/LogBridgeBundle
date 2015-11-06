<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status\Type;

use atoum\AtoumBundle\Test\Units;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\UpperType as TestedClass;

class UpperType extends Units\Test
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