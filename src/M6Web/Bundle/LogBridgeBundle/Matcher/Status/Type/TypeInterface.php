<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Interface TypeInterface
 */
interface TypeInterface
{
    /**
     * Match with config status
     */
    public function match(string $config): bool;

    /**
     * Get status list
     *
     * @return array<int, string|int>
     */
    public function getStatus(string $config): array;

    /**
     * Match with config status
     */
    public function isExclude(string $config): bool;
}
