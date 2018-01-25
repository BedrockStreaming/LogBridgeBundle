<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use Psr\Log\LogLevel;

/**
 * MatcherInterface
 */
interface MatcherInterface
{
    /**
     * match
     *
     * @param string $route  Route name
     * @param string $method Method name
     * @param int    $status Http code status
     *
     * @return bool
     */
    public function match($route, $method, $status);

    /**
     * addFilter
     *
     * @param string $filter  Filter name
     * @param string $level   Filter log level
     * @param array  $options Filter options
     *
     * @return MatcherInterface
     */
    public function addFilter($filter, $level = LogLevel::INFO, array $options = []);

    /**
     * setFilters
     *
     * @param array $filters   Filter list
     * @param bool  $overwrite Overwrite current filter
     *
     * @return MatcherInterface
     */
    public function setFilters(array $filters, $overwrite = false);

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters();

    /**
     * hasFilter
     *
     * @param string $filter Filter
     *
     * @return bool
     */
    public function hasFilter($filter);

    /**
     * Get filter level log
     *
     * @param string $route  Route name
     * @param string $method Method name
     * @param int    $status Http code status
     *
     * @return string
     */
    public function getLevel($route, $method, $status);

    /**
     * get options
     *
     * @param string $route  Route name
     * @param string $method Method name
     * @param int    $status Http code status
     *
     * @return array
     */
    public function getOptions($route, $method, $status);

    /**
     * get an filter key matched with arguments
     *
     * @param string $route  Route name
     * @param string $method Method name
     * @param int    $status Http code status
     *
     * @return bool|string
     */
    public function getMatchFilterKey($route, $method, $status);
}
