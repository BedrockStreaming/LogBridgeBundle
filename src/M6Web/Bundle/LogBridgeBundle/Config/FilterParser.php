<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

use Psr\Log\LogLevel;
use Symfony\Component\Routing\RouterInterface;

/**
 * FilterParser
 */
class FilterParser
{
    public const DEFAULT_LEVEL = LogLevel::INFO;

    protected array $allowedLevels = [
        LogLevel::EMERGENCY,
        LogLevel::ALERT,
        LogLevel::CRITICAL,
        LogLevel::ERROR,
        LogLevel::WARNING,
        LogLevel::NOTICE,
        LogLevel::INFO,
        LogLevel::DEBUG,
    ];

    protected string $filterClass;

    public function __construct(protected ?RouterInterface $router = null)
    {
        $this->filterClass = '';
    }

    protected function createFilter(string $name): Filter
    {
        if ($this->filterClass !== '') {
            return (new \ReflectionClass($this->filterClass))->newInstanceArgs(['name' => $name]);
        }

        return new Filter($name);
    }

    protected function isRoute(string $name): bool
    {
        return $this->router->getRouteCollection()->get($name) !== null;
    }

    public function parse(string $name, array $config): Filter
    {
        if (
            !array_key_exists('route', $config) ||
            !array_key_exists('method', $config) ||
            !array_key_exists('status', $config)
        ) {
            throw new ParseException(sprintf('Undefined "route", "method" or "status" parameter from filter "%s"', $name));
        }

        if (!array_key_exists('level', $config)) {
            $config['level'] = self::DEFAULT_LEVEL;
        }

        $filter = $this->createFilter($name);

        $this->parseRoute($filter, $config['route']);
        $this->parseMethod($filter, $config['method']);
        $this->parseStatus($filter, $config['status']);
        $this->parseLevel($filter, $config['level']);

        return $filter->setOptions($config['options'] ?? []);
    }

    protected function parseRoute(Filter $filter, mixed $route): void
    {
        if ($route !== null && !$this->isRoute($route)) {
            throw new ParseException(sprintf('Undefined route "%s" from router service', $route));
        }

        $filter->setRoute($route);
    }

    protected function parseMethod(Filter $filter, mixed $method): void
    {
        if (!is_array($method) && $method !== null) {
            throw new ParseException(sprintf('Unrecognized value "%s" from method parameter', $method));
        }

        $filter->setMethod($method);
    }

    protected function parseStatus(Filter $filter, mixed $status): void
    {
        if (!is_array($status) && $status !== null) {
            throw new ParseException(sprintf('Unrecognized value "%s" from status parameter', $status));
        }

        $filter->setStatus($status);
    }

    protected function parseLevel(Filter $filter, mixed $level): void
    {
        if (!is_string($level) && $level !== null) {
            throw new ParseException(sprintf('Unrecognized value "%s" from level parameter', $level));
        }

        if (!in_array($level, $this->allowedLevels, true)) {
            throw new ParseException(sprintf('Invalid value "%s" from level parameter, allowed %s', $level, implode(', ', $this->allowedLevels)));
        }

        $filter->setLevel($level);
    }

    public function setRouter(RouterInterface $router): self
    {
        $this->router = $router;

        return $this;
    }

    public function setFilterClass(string $filterClass): self
    {
        $reflection = new \ReflectionClass($filterClass);

        if (
            !$reflection->isInstantiable() ||
            !$reflection->isSubclassOf(Filter::class)
        ) {
            throw new \RuntimeException(sprintf('"%s" is not instantiable or is not a subclass of "%s"', $filterClass, Filter::class));
        }

        $this->filterClass = $filterClass;

        return $this;
    }

    public function getFilterClass(): string
    {
        return $this->filterClass;
    }
}
