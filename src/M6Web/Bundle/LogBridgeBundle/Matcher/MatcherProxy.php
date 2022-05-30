<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use Psr\Log\LogLevel;

/**
 * MatcherProxy
 */
class MatcherProxy implements MatcherInterface
{
    private MatcherInterface $matcher;

    public function __construct(private BuilderInterface $builder)
    {
        $this->matcher = $builder->getMatcher();
    }

    public function match(string $route, string $method, int $status): bool
    {
        return $this->matcher->match($route, $method, $status);
    }

    public function getLevel(string $route, string $method, int $status): string
    {
        return $this->matcher->getLevel($route, $method, $status);
    }

    public function getOptions(string $route, string $method, int $status): array
    {
        return $this->matcher->getOptions($route, $method, $status);
    }

    public function addFilter(string $filter, string $level = LogLevel::INFO, array $options = []): self
    {
        $this->matcher->addFilter($filter, $level, $options);

        return $this;
    }

    public function setFilters(array $filters, bool $overwrite = false): self
    {
        $this->matcher->setFilters($filters, $overwrite);

        return $this;
    }

    public function getFilters(): array
    {
        return $this->matcher->getFilters();
    }

    public function hasFilter($filter): bool
    {
        return $this->matcher->hasFilter($filter);
    }

    public function getMatcher(): MatcherInterface
    {
        return $this->matcher;
    }

    public function getBuilder(): BuilderInterface
    {
        return $this->builder;
    }

    /**
     * get a filter key matched with arguments
     */
    public function getMatchFilterKey(string $route, string $method, int $status): ?string
    {
        return $this->matcher->getMatchFilterKey($route, $method, $status);
    }
}
