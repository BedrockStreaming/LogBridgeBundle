<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Class UpperType
 */
class UpperType extends AbstractType
{
    protected function getPattern(): string
    {
        return '/^!?\^[\d]{3}$/';
    }

    /**
     * Transform config to status list
     */
    protected function transform(string $config): array
    {
        $startStatus = (int) substr($config, 1, 3);

        return range(
            $startStatus,
            ($startStatus - $startStatus % 100) + 100 - 1
        );
    }
}
