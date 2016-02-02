<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class RangeType
 */
class RangeType extends AbstractType implements TypeInterface
{
    /**
     * getPattern
     *
     * @return string
     */
    protected function getPattern()
    {
        return '/^!?[\d]{3}-[\d]{3}$/';
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
        $rangeStatus = explode('-', $config);

        if ($rangeStatus[1] < $rangeStatus[0]) {
            throw new InvalidArgumentException(sprintf('status "%s" isn\'t allowed, %d must be greater than %d', $config, $rangeStatus[1], $rangeStatus[0]));
        }

        return range(
            $rangeStatus[0],
            $rangeStatus[1]
        );
    }
}