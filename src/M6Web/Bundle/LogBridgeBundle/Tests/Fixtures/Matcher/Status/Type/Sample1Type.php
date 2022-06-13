<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Fixtures\Matcher\Status\Type;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\AbstractType;

/**
 * Class Sample1Type
 */
class Sample1Type extends AbstractType
{
    protected function getPattern(): string
    {
        return '/^!?[\d]{3}$/';
    }

    /**
     * Transform config to status list
     */
    public function transform(string $config): array
    {
        return [$config];
    }
}
