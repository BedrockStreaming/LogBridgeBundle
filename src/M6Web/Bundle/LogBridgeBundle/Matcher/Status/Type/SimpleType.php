<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Class SimpleType
 */
class SimpleType extends AbstractType
{
    protected function getPattern(): string
    {
        return '/^!?[\d]{3}$/';
    }

    /**
     * Transform config to status list
     */
    protected function transform(string $config): array
    {
        return [$config];
    }
}
