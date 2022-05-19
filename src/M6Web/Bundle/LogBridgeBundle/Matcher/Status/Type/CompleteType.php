<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Class CompleteType
 */
class CompleteType extends AbstractType
{
    protected function getPattern(): string
    {
        return '/^!?[\d]{1,2}\*$/';
    }

    /**
     * Transform config to status list
     */
    protected function transform(string $config): array
    {
        $refStatus = substr($config, 0, strlen((string) ((int) $config - 2)));

        $rangeInterval = 100;
        if (strlen($refStatus) === 2) {
            $rangeInterval = 10;
        }

        $startStatus = (int) str_pad($refStatus, 3, '0');

        return range(
            $startStatus,
            $startStatus + $rangeInterval - 1
        );
    }
}
