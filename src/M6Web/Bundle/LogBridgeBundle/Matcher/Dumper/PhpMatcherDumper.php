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
     * @param string  \$environment Environment name
     * @param string  \$route       Route name
     * @param string  \$method      Method name
     * @param integer \$status      Http code status
     *
     * @return boolean
     */   
    public static function match(\$environment, \$route, \$method, \$status)
    {
        if (in_array(self::generateKey(\$environment, \$route, \$method, \$status), self::\$filters)) {
            return true;
        }

        if (in_array(self::generateKey(\$environment, \$route, 'all', \$status), self::\$filters)) {
            return true;
        }

        if (in_array(self::generateKey(\$environment, \$route, \$method, 'all'), self::\$filters)) {
            return true;
        }

        if (in_array(self::generateKey(\$environment, \$route, 'all', 'all'), self::\$filters)) {
            return true;
        }

        return false;
    }

    /**
     * generateKey
     *
     * @param string  \$environment Environment name
     * @param string  \$route       Route name
     * @param string  \$method      Method name
     * @param integer \$status      Http code status
     *
     * @return string
     */
    public static function generateKey(\$environment, \$route, \$method, \$status)
    {
        return sprintf('%s.%s.%s.%s', \$environment, \$route, \$method, \$status);
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
    private static \$filters = [
{$code}    ];
EOF;

    }

    private function compile(Configuration $configuration)
    {
        $environments    = $configuration->getEnvironments();
        $compiledFilters = [];

        foreach ($environments as $name => $aliasList) {
            $compiledFilters = array_merge(
                $compiledFilters,
                $this->compileEnvironment(
                    $name,
                    $aliasList,
                    $configuration->getFilters()
                )
            );
        }

        return array_unique($compiledFilters, SORT_STRING);
    }


    private function compileEnvironment($name, $aliasList, FilterCollection $filters)
    {
        $compiled = [];

        if ($aliasList == 'all') {
            foreach ($filters as $filter) {
                $compiled = $this->compileFilter($name, $filter);
            }
        } else {
            foreach ($aliasList as $alias) {
                if ($filter = $filters->getByName($alias)) {
                    $compiled = array_merge($compiled, $this->compileFilter($name, $filter));
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
    private function compileFilter($prefix, Filter $filter)
    {
        $prefix   = sprintf('%s.%s', $prefix, $filter->getRoute());
        $compiled = [];

        if ($filter->getMethod() == 'all') {
            $prefix = sprintf('%s.all', $prefix, $filter->getMethod());

            $compiled = $this->compileFilterStatus($prefix, $filter);
        } else {
            foreach ($filter->getMethod() as $method) {
                $methodPrefix = sprintf('%s.%s', $prefix, $method);

                $compiled = array_merge($compiled, $this->compileFilterStatus($methodPrefix, $filter));
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
