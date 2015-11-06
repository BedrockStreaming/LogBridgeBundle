<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status\Type;

use atoum\AtoumBundle\Test\Units;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\CompleteType as TestedClass;

class CompleteType extends Units\Test
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
                '5*',
                range(500, 599)
            ],
            [
                '51*',
                range(510, 519)
            ],
            [
                '53*',
                range(530, 539)
            ],
            [
                '!5*',
                range(500, 599)
            ],
            [
                '!51*',
                range(510, 519)
            ],
            [
                '!53*',
                range(530, 539)
            ],
        ];
    }
}