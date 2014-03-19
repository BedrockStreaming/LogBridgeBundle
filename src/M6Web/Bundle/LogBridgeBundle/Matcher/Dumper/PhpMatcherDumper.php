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
            if (in_array(\$this->generateKey(\$route, \$method, \$status), \$this->filters)) {
                return true;
            }

            if (in_array(\$this->generateKey('all', 'all', 'all'), \$this->filters)) {
                return true;
            }

            if (in_array(\$this->generateKey(\$route, 'all', 'all'), \$this->filters)) {
                return true;
            }

            if (in_array(\$this->generateKey(\$route, \$method, 'all'), \$this->filters)) {
                return true;
            }

            if (in_array(\$this->generateKey(\$route, 'all', \$status), \$this->filters)) {
                return true;
            }

            if (in_array(\$this->generateKey('all', \$method, \$status), \$this->filters)) {
                return true;
            }

            if (in_array(\$this->generateKey('all', 'all', \$status), \$this->filters)) {
                return true;
            }

            if (in_array(\$this->generateKey('all', \$method, 'all'), \$this->filters)) {
                return true;
            }
        }

        return false;
    }

    /**
     * generateKey
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
     * addFilter
     *
     * @param string \$filter Filter
     *
     * @return MatcherInterface
     */
    public function addFilter(\$filter)
    {
        if (!\$this->hasFilter(\$filter)) {
            \$this->filters[] = \$filter;
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
            foreach (\$filters as \$filter) {
                \$this->addFilter(\$filter);
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
        return in_array(\$filter, \$this->filters);
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
        $code    = '';

        foreach ($filters as $filter) {
            $code .= sprintf("        '%s',\n", $filter);
        }

        $code = trim($code, ',');

        return <<<EOF
/**
     * @var array
     * List of compiled filters
     */
    private \$filters = [
{$code}    ];
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

        return array_unique($compiledFilters, SORT_STRING);
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
        $compiled = [];
        $prefix   = ($filter->getRoute() == 'all') ? 'all': $filter->getRoute();

        if ($filter->getMethod() == 'all') {
            $prefix   = sprintf('%s.all', $prefix, $filter->getMethod());
            $compiled = $this->compileFilterStatus($prefix, $filter);
        } else {
            foreach ($filter->getMethod() as $method) {
                $methodPrefix = sprintf('%s.%s', $prefix, $method);
                $compiled     = array_merge($compiled, $this->compileFilterStatus($methodPrefix, $filter));
            }
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

}
