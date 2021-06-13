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
