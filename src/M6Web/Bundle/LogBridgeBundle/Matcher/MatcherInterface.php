<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use Psr\Log\LogLevel;

/**
 * MatcherInterface
 */
interface MatcherInterface
{
    public function match(string $route, string $method, int $status): bool;

    /**
     * @param array<string, mixed> $options
     */
    public function addFilter(string $filter, string $level = LogLevel::INFO, array $options = []): self;

    /**
     * @param array<string, mixed> $filters
     */
    public function setFilters(array $filters, bool $overwrite = false): self;

    /**
     * @return array<string, mixed>
     */
    public function getFilters(): array;

    public function hasFilter(string $filter): bool;

    public function getLevel(string $route, string $method, int $status): string;

    /**
     * @return array<string, mixed>
     */
    public function getOptions(string $route, string $method, int $status): array;

    /**
     * get a filter key matched with arguments
     */
    public function getMatchFilterKey(string $route, string $method, int $status): ?string;
}
