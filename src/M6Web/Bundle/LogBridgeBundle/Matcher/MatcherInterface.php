<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

/**
 * MatcherInterface
 */
interface MatcherInterface
{
    /**
     * match
     *
     * @param string  $route       Route name
     * @param string  $method      Method name
     * @param integer $status      Http code status
     *
     * @return boolean
     */   
    public function match($route, $method, $status);

    /**
     * addFilter
     *
     * @param string $filter  Filter name
     * @param array  $options Filter options
     *
     * @return MatcherInterface
     */
    public function addFilter($filter, array $options = []);

    /**
     * setFilters
     *
     * @param array $filters Filter list
     * @param boolean $overwrite Overwrite current filter
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
     * @return boolean
     */
    public function hasFilter($filter);

}
