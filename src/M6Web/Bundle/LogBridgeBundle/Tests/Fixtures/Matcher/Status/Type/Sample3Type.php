<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\AbstractType;

/**
 * Class Sample3Type
 */
class Sample3Type extends AbstractType
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
