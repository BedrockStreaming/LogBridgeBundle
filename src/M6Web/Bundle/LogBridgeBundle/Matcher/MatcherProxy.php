<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use Psr\Log\LogLevel;

/**
 * MatcherProxy
 */
class MatcherProxy implements MatcherInterface
{
    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @var MatcherInterface
     */
    private $matcher;

    /**
     * __construct
     *
     * @param BuilderInterface $builder Matcher builder
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
        $this->matcher = $builder->getMatcher();
    }

    /**
     * match
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return boolean
     */
    public function match($route, $method, $status)
    {
        return $this->matcher->match($route, $method, $status);
    }

    /**
     * Get filter level log
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return string
     */
    public function getLevel($route, $method, $status)
    {
        return $this->matcher->getLevel($route, $method, $status);
    }

    /**
     * get options
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return array
     */
    public function getOptions($route, $method, $status)
    {
        return $this->matcher->getOptions($route, $method, $status);
    }

    /**
     * addFilter
     *
     * @param string $filter  Filter
     * @param string $level   Log level
     * @param array  $options Options
     *
     * @return MatcherProxy
     */
    public function addFilter($filter, $level = LogLevel::INFO, array $options = [])
    {
        $this->matcher->addFilter($filter, $level, $options);

        return $this;
    }

    /**
     * setFilters
     *
     * @param array $filters   Filter list
     * @param bool  $overwrite need overwrite filter
     *
     * @return MatcherProxy
     */
    public function setFilters(array $filters, $overwrite = false)
    {
        $this->matcher->setFilters($filters, $overwrite);

        return $this;
    }

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->matcher->getFilters();
    }

    /**
     * hasFilter
     *
     * @param string $filter Filter
     *
     * @return boolean
     */
    public function hasFilter($filter)
    {
        return $this->matcher->hasFilter($filter);
    }

    /**
     * getMatcher
     *
     * @return MatcherInterface
     */
    public function getMatcher()
    {
        return $this->matcher;
    }

    /**
     * getBuilder
     *
     * @return BuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * get an filter key matched with arguments
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return BuilderInterface
     */
    public function getMatchFilterKey($route, $method, $status)
    {
        return $this->matcher->getMatchFilterKey($route, $method, $status);
    }


}
