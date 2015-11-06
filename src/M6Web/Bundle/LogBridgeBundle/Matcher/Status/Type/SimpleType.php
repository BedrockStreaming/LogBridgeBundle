<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Class SimpleType
 */
class SimpleType extends AbstractType implements TypeInterface
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
    protected function transform($config)
    {
        return [$config];
    }
}