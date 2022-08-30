<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Dumper;

use M6Web\Bundle\LogBridgeBundle\Config\Configuration;
use M6Web\Bundle\LogBridgeBundle\Config\Filter;
use M6Web\Bundle\LogBridgeBundle\Config\FilterCollection;
use M6Web\Bundle\LogBridgeBundle\Matcher\Status\TypeManager as StatusTypeManager;
use Psr\Log\LogLevel;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;

/**
 * PhpMatcherDumper
 * Generate Php class cache
 */
class PhpMatcherDumper
{
    /**
     * __construct
     *
     * @param StatusTypeManager $statusTypeManager Status type manager
     */
    public function __construct(private StatusTypeManager $statusTypeManager)
    {
    }

    /**
     * @param array<string, string> $options
     */
    public function dump(Configuration $configuration, array $options = []): string
    {
        $options = array_replace([
            'class' => 'LogBridgeMatcher',
            'interface' => \M6Web\Bundle\LogBridgeBundle\Matcher\MatcherInterface::class,
            'default_level' => LogLevel::INFO,
        ], $options);

        return <<<EOF
<?php

/**
 * {$options['class']}
 *
 * This class has been auto-generated
 * by the M6Web LogBridgeBundle.
 */
class {$options['class']} implements {$options['interface']}
{
    {$this->generateMatchList($configuration)}

    private function getPositiveMatcher(string \$route, string \$method, int \$status): array
    {
        return [
            [\$route, \$method, \$status],
            [\$route, \$method, 'all'],
            [\$route, 'all', \$status],
            ['all', \$method, \$status],
            [\$route, 'all', 'all'],
            ['all', 'all', \$status],
            ['all', \$method, 'all'],
            ['all', 'all', 'all']
        ];
    }

    public function match(string \$route, string \$method, int \$status): bool
    {
        return \$this->getMatchFilterKey(\$route, \$method, \$status) !== null;
    }

    public function generateFilterKey(string \$route, string \$method, string \$status): string
    {
        return sprintf('%s.%s.%s', \$route, \$method, \$status);
    }

    public function getOptions(string \$route, string \$method, int \$status): array
    {
        if (\$filterKey = \$this->getMatchFilterKey(\$route, \$method, \$status)) {
            return \$this->filters[\$filterKey]['options'];
        }

        return [];
    }

    public function getLevel(string \$route, string \$method, int \$status): string
    {
        if (\$filterKey = \$this->getMatchFilterKey(\$route, \$method, \$status)) {
            return \$this->filters[\$filterKey]['level'];
        }

        return '{$options['default_level']}';
    }

    public function addFilter(string \$filter, string \$level = '{$options['default_level']}', array \$options = []): self
    {
        if (!\$this->hasFilter(\$filter)) {
            \$this->filters[\$filter]            = [];
            \$this->filters[\$filter]['options'] = \$options;
            \$this->filters[\$filter]['level']   = \$level;
        }

        return \$this;
    }

    public function setFilters(array \$filters, bool \$overwrite = false): self
    {
        if (\$overwrite) {
            \$this->filters = \$filters;
        } else {
            foreach (\$filters as \$filterKey => \$filter) {

                if (!isset(\$filter['level'])) {
                    \$filter['level'] = '{$options['default_level']}';
                }

                if (!isset(\$filter['options'])) {
                    \$filter['options'] = [];
                }

                \$this->addFilter(\$filterKey, \$filter['level'], \$filter['options']);
            }
        }

        return \$this;
    }

    public function getFilters(): array
    {
        return \$this->filters;
    }

    public function hasFilter(string \$filter): bool
    {
        return array_key_exists(\$filter, \$this->filters);
    }

    public function getMatchFilterKey(string \$route, string \$method, int \$status): ?string
    {
        if (!empty(\$this->filters)) {
            foreach (\$this->getPositiveMatcher(\$route, \$method, \$status) as \$rms) {
                \$filterKey = \$this->generateFilterKey(\$rms[0], \$rms[1], \$rms[2]);
                if (\$this->hasFilter(\$filterKey)) {
                    return \$filterKey;
                }
            }
        }

        return null;
    }
}

EOF;
    }

    private function generateMatchList(Configuration $configuration): string
    {
        $filters = $this->compile($configuration);
        $code = "[\n";

        foreach ($filters as $filterKey => $filter) {
            $code .= sprintf("        '%s' => [\n", $filterKey);

            foreach ($filter as $key => $config) {
                if (is_array($config)) {
                    $code .= sprintf("            '%s' => [", $key);

                    if (count($config) > 0) {
                        $code .= "\n";

                        foreach ($config as $name => $value) {
                            if (is_bool($value)) {
                                $value = $value == true ? 'true' : 'false';
                            } else {
                                $value = "'".$value."'";
                            }

                            $code .= sprintf("                '%s' => %s,\n", $name, $value);
                        }

                        $code .= '            ';
                    }

                    $code .= "],\n";
                } else {
                    $code .= sprintf("            '%s' => '%s',\n", $key, $config);
                }
            }

            $code = trim($code, ',');
            $code .= "        ],\n";
        }

        $code = trim($code, ",\n");
        $code .= "\n    ]";

        return <<<EOF
/**
     * List of compiled filters
     */
    private array \$filters = {$code};
EOF;
    }

    /**
     * @return array<string, array{
     *     level: ?string,
     *     options: array<string, bool|string>
     * }>
     */
    private function compile(Configuration $configuration): array
    {
        $filters = $configuration->getFilters();
        if ($filters === null) {
            return [];
        }

        return $this->compileNeededFilters(
            $configuration->getActiveFilters(),
            $filters
        );
    }

    /**
     * @param string[]|null $activeFilters
     *
     * @return array<string, array{
     *     level: ?string,
     *     options: array<string, bool|string>
     * }>
     */
    private function compileNeededFilters(?array $activeFilters, FilterCollection $filters): array
    {
        $compiled = [];

        if ($activeFilters === null) {
            foreach ($filters as $filter) {
                $compiled = array_merge($compiled, $this->compileFilter($filter));
            }
        } else {
            foreach ($activeFilters as $activeFilter) {
                if ($filter = $filters->getByName($activeFilter)) {
                    $compiled = array_merge($compiled, $this->compileFilter($filter));
                }
            }
        }

        return $compiled;
    }

    /**
     * @return array<string, array{
     *     level: ?string,
     *     options: array<string, bool|string>
     * }>
     */
    private function compileFilter(Filter $filter): array
    {
        $compiledKeys = [];
        $compiled = [];
        /** @var array $routesPrefix */
        $routesPrefix = $filter->getRoutes();
        /** @var string $prefix */
        $prefix = is_null($filter->getRoute()) ? 'all' : $filter->getRoute();

        $compiledKeys = isset($routesPrefix) ?
            $this->compileFilterRoutes($filter, $routesPrefix, $compiledKeys) :
            $this->compileFilterRoute($filter, $prefix, $compiledKeys);

        foreach ($compiledKeys as $key) {
            $compiled[$key]['options'] = $filter->getOptions();
            $compiled[$key]['level'] = $filter->getLevel();
        }

        return $compiled;
    }

    private function compileFilterRoute(Filter $filter, string $prefix, array $compiledKeys): array
    {
        if (empty($filter->getMethod())) {
            $prefix = sprintf('%s.all', $prefix);
            $compiledKeys = $this->compileFilterStatus($prefix, $filter);
        } else {
            foreach ($filter->getMethod() as $method) {
                $methodPrefix = sprintf('%s.%s', $prefix, $method);
                $compiledKeys = array_merge($compiledKeys, $this->compileFilterStatus($methodPrefix, $filter));
            }
        }

        return $compiledKeys;
    }

    private function compileFilterRoutes(Filter $filter, ?array $routesPrefix, array $compiledKeys): array
    {
        if (empty($filter->getMethod())) {
            foreach ($routesPrefix as $routePrefix) {
                $prefix = sprintf('%s.all', $routePrefix);
                $compiledKeys = array_merge($compiledKeys, $this->compileFilterStatus($prefix, $filter));
            }

            return $compiledKeys;
        }

        foreach ($filter->getMethod() as $method) {
            foreach ($routesPrefix as $routePrefix) {
                $methodPrefix = sprintf('%s.%s', $routePrefix, $method);
                $compiledKeys = array_merge($compiledKeys, $this->compileFilterStatus($methodPrefix, $filter));
            }
        }

        return $compiledKeys;
    }

    /**
     * @return string[]
     */
    private function compileFilterStatus(?string $prefix, Filter $filter): array
    {
        $compiled = [];
        /** @var string[]|null $filterStatusList */
        $filterStatusList = $filter->getStatus();

        if (is_null($filterStatusList)) {
            $compiled[] = sprintf('%s.all', $prefix);
        } else {
            foreach ($this->parseStatus($filterStatusList) as $status) {
                $compiled[] = sprintf('%s.%s', $prefix, $status);
            }
        }

        return $compiled;
    }

    /**
     * @param string[] $filterStatusList
     *
     * @return string[]|int[]
     */
    private function parseStatus(array $filterStatusList): array
    {
        $statusList = [];
        $statusTypes = $this->statusTypeManager->getTypes();

        foreach ($filterStatusList as $value) {
            $matched = false;
            foreach ($statusTypes as $statusType) {
                if ($statusType->match($value)) {
                    $matched = true;

                    if ($statusType->isExclude($value)) {
                        $statusList = array_diff($statusList, $statusType->getStatus($value));
                    } else {
                        $statusList = [...$statusList, ...$statusType->getStatus($value)];
                    }

                    break;
                }
            }

            if (!$matched) {
                throw new InvalidArgumentException(sprintf('Status %s not allowed in log bridge configuration filters', $value));
            }
        }

        return array_unique($statusList, SORT_NUMERIC);
    }
}
