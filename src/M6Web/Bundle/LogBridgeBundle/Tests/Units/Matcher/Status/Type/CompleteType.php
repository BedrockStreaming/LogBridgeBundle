<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status\Type;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\CompleteType as TestedClass;

class CompleteType extends atoum
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
