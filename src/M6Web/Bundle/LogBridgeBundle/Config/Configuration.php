<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Class Configuration
 */
class Configuration
{
    /** @var FilterCollection */
    private $filters;

    /** @var array */
    private $activeFilters;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->filters = null;
        $this->activeFilters = null;
    }

    /**
     * setActiveFilters
     *
     * @return Configuration
     */
    public function setActiveFilters(array $activeFilters)
    {
        $this->activeFilters = $activeFilters;

        return $this;
    }

    /**
     * getActiveFilters
     *
     * @return array
     */
    public function getActiveFilters()
    {
        return $this->activeFilters;
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
