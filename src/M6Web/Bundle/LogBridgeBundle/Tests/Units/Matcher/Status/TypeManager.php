<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\AbstractType;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\TypeInterface;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\TypeManager as TestedClass;

class TypeManager extends atoum
{
    private function getType($number): AbstractType
    {
        $classType = sprintf('M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type\Sample%dType', $number);
        return new $classType();
    }

    /**
     * @dataProvider dataTestAddType
     */
    public function testAddType(array $types, array $result): void
    {
        $this
            ->given(
                $typeManager = new TestedClass()
            )
        ;

        foreach ($types as $type) {
            $typeManager->addType($type);
        }

        $this
            ->array($typeManager->getTypes())
            ->isEqualTo($result)
        ;
    }

    /**
     * Data to testAddType
     */
    public function dataTestAddType(): array
    {
        $type1 = $this->getType(1);
        $type2 = $this->getType(2);
        $type3 = $this->getType(3);

        return [
            [
                [
                    $type1,
                    $type3,
                    $type2,
                ],
                [
                    $type1::class => $type1,
                    $type3::class => $type3,
                    $type2::class => $type2,
                ]
            ]
        ];
    }

    /**
     * @dataProvider dataTestRemoveType
     */
    public function testRemoveType(array $types, TypeInterface $typeToRemove, array $result): void
    {
        $this
            ->given(
                $typeManager = new TestedClass()
            )
        ;

        foreach ($types as $type) {
            $typeManager->addType($type);
        }

        $this
            ->if($typeManager->removeType($typeToRemove))
            ->array($typeManager->getTypes())
            ->isEqualTo($result)
        ;
    }

    /**
     * Data to testRemoveType
     */
    public function dataTestRemoveType(): array
    {
        $type1 = $this->getType(1);
        $type2 = $this->getType(2);
        $type3 = $this->getType(3);

        return [
            [
                [
                    $type2,
                    $type3,
                    $type1,
                ],
                $type2,
                [
                    $type3::class => $type3,
                    $type1::class => $type1,
                ]
            ]
        ];
    }
}
