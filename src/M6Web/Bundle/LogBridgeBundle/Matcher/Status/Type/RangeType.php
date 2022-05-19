<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * Class RangeType
 */
class RangeType extends AbstractType
{
    protected function getPattern(): string
    {
        return '/^!?[\d]{3}-[\d]{3}$/';
    }

    /**
     * Transform config to status list
     */
    protected function transform(string $config): array
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
