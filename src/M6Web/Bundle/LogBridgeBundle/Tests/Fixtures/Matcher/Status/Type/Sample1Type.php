<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\AbstractType;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\TypeInterface;

/**
 * Class Sample1Type
 */
class Sample1Type extends AbstractType implements TypeInterface
{
    /**
     * getPattern
     *
     * @return string
     */
    protected function getPattern()
    {
        return '/^!?[\d]{3}$/';
    }

    /**
     * Transform config to status list
     *
     * @param string $config
     *
     * @return array
     */
    public function transform($config)
    {
        return [$config];
    }
}
