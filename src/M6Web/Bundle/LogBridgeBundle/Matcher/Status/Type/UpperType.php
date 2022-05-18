<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Class UpperType
 */
class UpperType extends AbstractType implements TypeInterface
{
    /**
     * getPattern
     *
     * @return string
     */
    protected function getPattern()
    {
        return '/^!?\^[\d]{3}$/';
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
        $startStatus = substr($config, 1, 3);

        return range(
            $startStatus,
            ($startStatus - $startStatus % 100) + 100 - 1
        );
    }
}
