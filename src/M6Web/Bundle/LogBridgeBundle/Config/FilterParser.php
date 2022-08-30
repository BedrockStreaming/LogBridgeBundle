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

    /** @var string[] */
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

    /** @var class-string<Filter>|null */
    protected ?string $filterClass = null;

    public function __construct(protected ?RouterInterface $router = null)
    {
    }

    protected function createFilter(string $name): Filter
    {
        if ($this->filterClass !== null) {
            return (new \ReflectionClass($this->filterClass))->newInstanceArgs([$name]);
        }

        return new Filter($name);
    }

    protected function isRoute(string $name): bool
    {
        return $this->router?->getRouteCollection()->get($name) !== null;
    }

    protected function getAllRoutes(): array
    {
        $routesCollection = $this->router?->getRouteCollection()->all();

        return array_keys($routesCollection);
    }

    /**
     * @param array{
     *     route?: string,
     *     routes?: string[],
     *     method?: string[],
     *     status?: int[],
     *     level?: string,
     *     options?: array{post_parameters?: bool, response_body?: bool}
     * } $config
     */
    public function parse(string $name, array $config): Filter
    {
        if (
            (!array_key_exists('route', $config) && !array_key_exists('routes', $config)) ||
            !array_key_exists('method', $config) ||
            !array_key_exists('status', $config)
        ) {
            throw new ParseException(sprintf('Undefined "route(s)", "method" or "status" parameter from filter "%s"', $name));
        }

        if ((array_key_exists('route', $config) && $config['route'] !== null) && (array_key_exists('routes', $config) && !empty($config['routes']))) {
            throw new ParseException(sprintf('You can\'t use both "route" and "routes" parameter from filter "%s"', $name));
        }

        if (!array_key_exists('level', $config)) {
            $config['level'] = self::DEFAULT_LEVEL;
        }

        $filter = $this->createFilter($name)
            ->setMethod($config['method'])
            ->setStatus($config['status']);

        if (array_key_exists('route', $config)) {
            $this->parseRoute($filter, $config['route']);
        }

        if (array_key_exists('routes', $config)) {
            $this->parseRoutes($filter, $config['routes'] ?? []);
        }

        $this->parseLevel($filter, $config['level']);

        return $filter->setOptions($config['options'] ?? []);
    }

    protected function parseRoute(Filter $filter, ?string $route): void
    {
        if ($route !== null && !$this->isRoute($route)) {
            throw new ParseException(sprintf('Undefined route "%s" from router service', $route));
        }

        $filter->setRoute($route);
    }

    protected function parseRoutes(Filter $filter, ?array $routes): void
    {
        if (empty($routes)) {
            $filter->setRoutes(['all']);

            return;
        }

        // Find and keep excluded routes
        $excludedRoutes = array_filter($routes, function (string $route) {
            return str_starts_with($route, '!');
        });

        // Create an array with routes not excluded
        $routes = array_diff_key($routes, $excludedRoutes);

        // Check that the route's name exist
        foreach ($routes as $route) {
            if (!$this->isRoute($route)) {
                throw new ParseException(sprintf('Undefined route "%s" from router service', $route));
            }
        }

        // If empty routes, return all routes except the excluded ones
        if (empty($routes)) {
            $existingRoutes = $this->getAllRoutes();
            $excludedRoutes = array_map(function (string $route) {
                return ltrim($route, '!');
            }, $excludedRoutes);

            $routes = array_values(array_diff($existingRoutes, $excludedRoutes));
        }

        $filter->setRoutes($routes);
    }

    protected function parseLevel(Filter $filter, ?string $level): void
    {
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

    /**
     * @param class-string<Filter> $filterClass
     */
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

    public function getFilterClass(): ?string
    {
        return $this->filterClass;
    }
}
