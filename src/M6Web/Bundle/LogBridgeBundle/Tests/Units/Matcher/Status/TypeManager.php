<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Matcher\Status;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\TypeInterface;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\TypeManager as TestedClass;

class TypeManager extends atoum
{
    /**
     * Get type
     *
     * @param integer $number
     *
     * @return M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type\Sample1Type
     */
    private function getType($number){
        $classType = sprintf('M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type\Sample%dType', $number);
        $type = new $classType();

        return $type;
    }

    /**
     * @dataProvider dataTestAddType
     *
     * @param array $types
     * @param array $result
     */
    public function testAddType(array $types, array $result) {

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
     *
     * @return array
     */
    public function dataTestAddType() {

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
                    get_class($type1) => $type1,
                    get_class($type3) => $type3,
                    get_class($type2) => $type2,
                ]
            ]
        ];

    }

    /**
     * @dataProvider dataTestRemoveType
     *
     * @param array         $types
     * @param TypeInterface $typeToRemove
     * @param array         $result
     */
    public function testRemoveType(array $types, $typeToRemove, array $result) {

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
     *
     * @return array
     */
    public function dataTestRemoveType() {

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
                    get_class($type3) => $type3,
                    get_class($type1) => $type1,
                ]
            ]
        ];

    }
}
