<?php

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Class Configuration
 *
 * @package M6Web\Bundle\LogBridgeBundle\Config
 */
class Configuration
{
    /**
     * @var array
     */
    private $environments;

    /**
     * @var FilterCollection
     */
    private $filters;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->environments = [];
        $this->filters      = null;
    }

    /**
     * setEnvironments
     *
     * @param array $environments Environments
     *
     * @return Configuration
     */
    public function setEnvironments(array $environments)
    {
        $this->environments = $environments;

        return $this;
    }

    /**
     * getEnvironments
     *
     * @return array
     */
    public function getEnvironments()
    {
        return $this->environments;
    }

    /**
     * setFilters
     *
     * @param FilterCollection $filters Filters
     *
     * @return Configuration
     */
    public function setFilters(FilterCollection $filters)
    {
        $this->filters = $filters;

        return $this;
    }

    /**
     * getFilters
     *
     * @return FilterCollection
     */
    public function getFilters()
    {
        return $this->filters;
    }

}
