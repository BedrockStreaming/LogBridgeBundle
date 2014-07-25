<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Dumper;

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
     *
     * @return string
     */
    public function dump(Configuration $configuration, array $options = array())
    {
        $options = array_replace(array(
            'class'     => 'LogBridgeMatcher',
            'interface' => 'M6Web\\Bundle\\LogBridgeBundle\\Matcher\\MatcherInterface'
        ), $options);

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
        if (!empty(\$this->filters)) {
            if (\$this->hasFilter(\$this->generateKey(\$route, \$method, \$status))) {
                return true;
            }

            if (\$this->hasFilter(\$this->generateKey('all', 'all', 'all'))) {
                return true;
            }

            if (\$this->hasFilter(\$this->generateKey(\$route, 'all', 'all'))) {
                return true;
            }

            if (\$this->hasFilter(\$this->generateKey(\$route, \$method, 'all'))) {
                return true;
            }

            if (\$this->hasFilter(\$this->generateKey(\$route, 'all', \$status))) {
                return true;
            }

            if (\$this->hasFilter(\$this->generateKey('all', \$method, \$status))) {
                return true;
            }

            if (\$this->hasFilter(\$this->generateKey('all', 'all', \$status))) {
                return true;
            }

            if (\$this->hasFilter(\$this->generateKey('all', \$method, 'all'))) {
                return true;
            }
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
    public function generateKey(\$route, \$method, \$status)
    {
        return sprintf('%s.%s.%s', \$route, \$method, \$status);
    }

    /**
     * Get filter options
     *
     * @param string \$key Filter key
     *
     * @return mixed (null|array)
     */
    public function getOptions(\$key)
    {
        return \$this->hasFilter(\$key) ? \$this->filters[\$key] : null;
    }

    /**
     * addFilter
     *
     * @param string \$filter Filter
     *
     * @return MatcherInterface
     */
    public function addFilter(\$filter, array \$options = [])
    {
        if (!\$this->hasFilter(\$filter)) {
            \$this->filters[\$filter] = \$options;
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
            foreach (\$filters as \$filter => \$options) {
                \$this->addFilter(\$filter, \$options);
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
     * @param string \$filter Filter
     *
     * @return boolean
     */
    public function hasFilter(\$filter)
    {
        return array_key_exists(\$filter, \$this->filters);
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
        $code    = "        [\n";

        foreach ($filters as $key => $config) {
            $code .= sprintf("        '%s' => [\n", $key);

            foreach ($config as $name => $value) {
                if (is_bool($value)) {
                    $value = $value == true ? 'true' : 'false';
                } else {
                    $value = "'". $value ."'";
                }

                $code .= sprintf("            '%s' => %s,\n", $name, $value);
            }

            $code = trim($code, ",");
            $code .= "        ],\n";
        }

        $code = trim($code, ',');
        $code .= "]";

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

        if (isset($environments[$this->environment])) {
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

        if ($aliasList == 'all') {
            foreach ($filters as $filter) {
                $compiled = $this->compileFilter($filter);
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
     * @param string $prefix Prefix key
     * @param Filter $filter Filter
     *
     * @return array
     */
    private function compileFilter(Filter $filter)
    {
        $compiledKeys = [];
        $compiled     = [];
        $options      = $this->compileFilterOptions($filter);
        $prefix       = ($filter->getRoute() == 'all') ? 'all': $filter->getRoute();

        if ($filter->getMethod() == 'all') {
            $prefix   = sprintf('%s.all', $prefix, $filter->getMethod());
            $compiledKeys = $this->compileFilterStatus($prefix, $filter);
        } else {
            foreach ($filter->getMethod() as $method) {
                $methodPrefix = sprintf('%s.%s', $prefix, $method);
                $compiledKeys     = array_merge($compiledKeys, $this->compileFilterStatus($methodPrefix, $filter));
            }
        }

        foreach ($compiledKeys as $key) {
            $compiled[$key] = $options;
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

        if ($filter->getStatus() == 'all') {
            $compiled[] = sprintf('%s.all', $prefix);
        } else {
            foreach ($filter->getStatus() as $status) {
                $compiled[] = sprintf('%s.%s', $prefix, $status);
            }
        }

        return $compiled;
    }

    /**
     * compile options from filter
     *
     * @param Filter $filter Filter
     *
     * @return array
     */
    private function compileFilterOptions(Filter $filter)
    {
        return [
            'content' => $filter->getContent()
        ];
    }
}
