<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Dumper;

use Psr\Log\LogLevel;
use M6Web\Bundle\LogBridgeBundle\Config\Configuration;
use M6Web\Bundle\LogBridgeBundle\Config\FilterCollection;
use M6Web\Bundle\LogBridgeBundle\Config\Filter;

/**
 * PhpMatcherDumper
 * Generate Php class cache
 *
 */
class PhpMatcherDumper
{
    /**
     * @var string
     */
    private $environment;

    /**
     * __construct
     *
     * @param string $environment Environment
     */
    public function __construct($environment)
    {
        $this->environment = $environment;
    }

    /**
     * dump
     *
     * @param Configuration $configuration
     * @param array         $options
     *
     * @return string
     */
    public function dump(Configuration $configuration, array $options = [])
    {

        $options = array_replace([
            'class'         => 'LogBridgeMatcher',
            'interface'     => 'M6Web\\Bundle\\LogBridgeBundle\\Matcher\\MatcherInterface',
            'default_level' => LogLevel::INFO
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

    /**
     * getPositiveMatcher
     *
     * @param string  \$route       Route name
     * @param string  \$method      Method name
     * @param integer \$status      Http code status
     *
     * @return array
     */
    private function getPositiveMatcher(\$route, \$method, \$status)
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

    /**
     * match
     *
     * @param string  \$route       Route name
     * @param string  \$method      Method name
     * @param integer \$status      Http code status
     *
     * @return boolean
     */   
    public function match(\$route, \$method, \$status)
    {
        if (\$filterKey = \$this->getMatchFilterKey(\$route, \$method, \$status)) {
            return true;
        }

        return false;
    }

    /**
     * generate filter key
     *
     * @param string  \$route  Route name
     * @param string  \$method Method name
     * @param integer \$status Http code status
     *
     * @return string
     */
    public function generateFilterKey(\$route, \$method, \$status)
    {
        return sprintf('%s.%s.%s', \$route, \$method, \$status);
    }

    /**
     * Get filter options
     *
     * @param string  \$route  Route name
     * @param string  \$method Method name
     * @param integer \$status Http code status
     *
     * @return array
     */
    public function getOptions(\$route, \$method, \$status)
    {
        if (\$filterKey = \$this->getMatchFilterKey(\$route, \$method, \$status)) {
            return \$this->filters[\$filterKey]['options'];
        }

        return [];
    }

    /**
     * Get filter level log
     *
     * @param string  \$route  Route name
     * @param string  \$method Method name
     * @param integer \$status Http code status
     *
     * @return string
     */
    public function getLevel(\$route, \$method, \$status)
    {
        if (\$filterKey = \$this->getMatchFilterKey(\$route, \$method, \$status)) {
            return \$this->filters[\$filterKey]['level'];
        }

        return '{$options['default_level']}';
    }

    /**
     * addFilter
     *
     * @param string \$filterKey Filter key
     * @param string \$level     Filter Log level
     * @param array  \$options   Filter options
     *
     * @return MatcherInterface
     */
    public function addFilter(\$filterKey, \$level = '{$options['default_level']}', array \$options = [])
    {
        if (!\$this->hasFilter(\$filterKey)) {
            \$this->filters[\$filterKey]            = [];
            \$this->filters[\$filterKey]['options'] = \$options;
            \$this->filters[\$filterKey]['level']   = \$level;
        }

        return \$this;
    }

    /**
     * setFilters
     *
     * @param array   \$filters   Filter list
     * @param boolean \$overwrite Overwrite current filter
     *
     * @return MatcherInterface
     */
    public function setFilters(array \$filters, \$overwrite = false)
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

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        return \$this->filters;
    }

    /**
     * hasFilter
     *
     * @param string \$filterKey Filter key
     *
     * @return boolean
     */
    public function hasFilter(\$filterKey)
    {
        return array_key_exists(\$filterKey, \$this->filters);
    }

    /**
     * get an filter key matched with arguments
     *
     * @param string  \$route  Route name
     * @param string  \$method Method name
     * @param integer \$status Http code status
     *
     * @return bool|string
     */
    public function getMatchFilterKey(\$route, \$method, \$status)
    {
        if (!empty(\$this->filters)) {
            foreach (\$this->getPositiveMatcher(\$route, \$method, \$status) as \$rms) {
                \$filterKey = \$this->generateFilterKey(\$rms[0], \$rms[1], \$rms[2]);
                if (\$this->hasFilter(\$filterKey)) {
                    return \$filterKey;
                }
            }
        }

        return false;
    }
}

EOF;
    }

    /**
     * generateMatchList
     *
     * @param Configuration $configuration
     *
     * @return string
     */
    private function generateMatchList(Configuration $configuration)
    {

        $filters = $this->compile($configuration);
        $code    = "[\n";

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
                                $value = "'" . $value . "'";
                            }

                            $code .= sprintf("                '%s' => %s,\n", $name, $value);
                        }

                        $code .= "            ";
                    }

                    $code .= "],\n";

                } else {
                    $code .= sprintf("            '%s' => '%s',\n", $key, $config);
                }

            }

            $code = trim($code, ",");
            $code .= "        ],\n";
        }

        $code = trim($code, ",\n");
        $code .= "\n    ]";

        return <<<EOF
/**
     * @var array
     * List of compiled filters
     */
    private \$filters = {$code};
EOF;

    }

    /**
     * compile
     *
     * @param Configuration $configuration Config
     *
     * @return array
     */
    private function compile(Configuration $configuration)
    {
        $environments    = $configuration->getEnvironments();
        $compiledFilters = [];

        if (array_key_exists($this->environment, $environments)) {
            $compiledFilters = $this->compileEnvironment(
                $environments[$this->environment],
                $configuration->getFilters()
            );
        }

        return $compiledFilters;
    }

    /**
     * compileEnvironment
     *
     * @param array            $aliasList List of alias filter
     * @param FilterCollection $filters   Filters
     *
     * @return array
     */
    private function compileEnvironment($aliasList, FilterCollection $filters)
    {
        $compiled = [];

        if (is_null($aliasList)) {
            foreach ($filters as $filter) {
                $compiled = array_merge($compiled, $this->compileFilter($filter));
            }
        } else {
            foreach ($aliasList as $alias) {
                if ($filter = $filters->getByName($alias)) {
                    $compiled = array_merge($compiled, $this->compileFilter($filter));
                }
            }
        }

        return $compiled;
    }

    /**
     * compileFilter
     *
     * @param Filter $filter Filter
     *
     * @internal param string $prefix Prefix key
     * @return array
     */
    private function compileFilter(Filter $filter)
    {
        $compiledKeys = [];
        $compiled     = [];
        $prefix       = is_null($filter->getRoute()) ? 'all': $filter->getRoute();

        if (is_null($filter->getMethod())) {
            $prefix   = sprintf('%s.all', $prefix, $filter->getMethod());
            $compiledKeys = $this->compileFilterStatus($prefix, $filter);
        } else {
            foreach ($filter->getMethod() as $method) {
                $methodPrefix = sprintf('%s.%s', $prefix, $method);
                $compiledKeys     = array_merge($compiledKeys, $this->compileFilterStatus($methodPrefix, $filter));
            }
        }

        foreach ($compiledKeys as $key) {
            $compiled[$key]['options'] = $filter->getOptions();
            $compiled[$key]['level'] = $filter->getLevel();
        }

        return $compiled;
    }

    /**
     * compileFilterStatus
     *
     * @param string $prefix Prefix key
     * @param Filter $filter Filter
     *
     * @return array
     */
    private function compileFilterStatus($prefix, $filter)
    {
        $compiled = [];

        if (is_null($filter->getStatus())) {
            $compiled[] = sprintf('%s.all', $prefix);
        } else {
            foreach ($filter->getStatus() as $status) {
                $compiled[] = sprintf('%s.%s', $prefix, $status);
            }
        }

        return $compiled;
    }

}
