<?php

namespace M6Web\Bundle\LogBridgeBundle\Config;

use Symfony\Component\Routing\RouterInterface;

/**
 * FilterParser
 */
class FilterParser
{
    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var string
     */
    protected $filterClass;

    /**
     * __construct
     *
     * @param RouterInterface $router Router service
     */
    public function __construct(RouterInterface $router = null)
    {
        $this->router      = $router;
        $this->filterClass = '';
    }

    /**
     * createFilter
     *
     * @param string $name Filter name
     *
     * @return Filter
     */
    protected function createFilter($name)
    {
        if ($this->filterClass) {
            return (new \ReflectionClass($this->filterClass))->newInstanceArgs(['name' => $name]); 
        }

        return new Filter($name);
    }

    /**
     * isAll
     * Test parameter value is "All"
     *
     * @param mixed $parameterValue Value
     *
     * @return boolean
     */
    protected function isAll($parameterValue)
    {
        if (is_string($parameterValue) && ($parameterValue == 'all' || $parameterValue == '*')) {
            return true;
        }

        return false;
    }

    /**
     * isRoute
     *
     * @param string $name Route name
     *
     * @return boolean
     */
    protected function isRoute($name)
    {
        return $this->router->getRouteCollection()->get($name) ? true : false;
    }

    /**
     * parse
     *
     * @param array $filterConfig
     *
     * @return Filter
     */
    public function parse($name, array $config)
    {
        $filter = $this->createFilter($name);

        if (empty($config['route']) || !isset($config['method']) || !isset($config['status'])) {
            throw new ParseException(sprintf('Undefined "route", "method" or "status" parameter from filter "%s"', $name));
        }

        $this->parseRoute($filter, $config['route']);
        $this->parseMethod($filter, $config['method']);
        $this->parseStatus($filter, $config['status']);

        return $filter;
    }

    /**
     * parseRoute
     *
     * @param Filter $filter Filter
     * @param mixed  $route  Route parameter value
     */
    protected function parseRoute(Filter $filter, $route)
    {
        if ($this->isAll($route)) {
            $filter->setRoute('all');
        } else {
            if (!$this->isRoute($route)) {
                throw new ParseException(sprintf('Undefined route "%s" from router service', $route));
            }

            $filter->setRoute($route);
        }
    }

    /**
     * parseMethod
     *
     * @param Filter $filter Filter
     * @param mixed  $method Method parameter value
     */
    protected function parseMethod(Filter $filter, $method)
    {
        // OPTIONS GET POST PUT DELETE HEAD PATCH TRACE CONNECT
        if ($this->isAll($method)) {
            $filter->setMethod('all');
        } else {
            if (!is_array($method)) {
                throw new ParseException(sprintf('Unreconized value "%s" from method parameter', $method));
            }

            $filter->setMethod($method);
        }
    }

    /**
     * parseStatus
     *
     * @param Filter $filter Filter
     * @param mixed  $status Status parameter value
     */
    protected function parseStatus(Filter $filter, $status)
    {
        // OPTIONS GET POST PUT DELETE HEAD PATCH TRACE CONNECT
        if ($this->isAll($status)) {
            $filter->setStatus('all');
        } else {
            if (!is_array($status)) {
                throw new ParseException(sprintf('Unreconized value "%s" from status parameter', $status));
            }

            $filter->setStatus($status);
        }
    }

    /**
     * setRouter
     *
     * @param RouterInterface $router Router
     *
     * @return FilterParser
     */
    public function setRoute(RouterInterface $router)
    {
        $this->router = $router;

        return $this;
    }


    /**
     * setFilterClass
     *
     * @param string $filterClass Filter class name
     *
     * @return FilterParser
     * @throws \RuntimeException
     */
    public function setFilterClass($filterClass)
    {
        $reflection = new \ReflectionClass($filterClass);

        if (
            !$reflection->isInstantiable()
             || !$reflection->isSubclassOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
        ) {
            throw new \RuntimeException(
                sprintf(
                    '"%s" is not instantiable or is not a subclass of "M6Web\Bundle\LogBridgeBundle\Config\Filter"',
                    $filterClass
                )
            );
        }

        $his->filterClass = $filterClass;

        return $this;
    }

    /**
     * getFilterClass
     *
     * @return string
     */
    public function getFilterClass()
    {
        return $this->filterClass;
    }

}
