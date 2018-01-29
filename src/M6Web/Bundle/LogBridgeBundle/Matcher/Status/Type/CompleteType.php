<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Class CompleteType
 */
class CompleteType extends AbstractType implements TypeInterface
{
    /**
     * getPattern
     *
     * @return string
     */
    protected function getPattern()
    {
        return '/^!?[\d]{1,2}\*$/';
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
        $refStatus = substr($config, 0, strlen((int) $config - 2));

        $rangeInternval = 100;
        if (strlen($refStatus) == 2) {
            $rangeInternval = 10;
        }

        $startStatus = (int) str_pad((string) $refStatus, 3, '0');

        return range(
            $startStatus,
            $startStatus + $rangeInternval - 1
        );
    }
}
