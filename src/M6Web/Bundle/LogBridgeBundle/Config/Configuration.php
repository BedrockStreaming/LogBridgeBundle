<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Class Configuration
 */
class Configuration
{
    private ?FilterCollection $filters;

    private ?array $activeFilters;

    public function __construct()
    {
        $this->filters = null;
        $this->activeFilters = null;
    }

    public function setActiveFilters(array $activeFilters): self
    {
        $this->activeFilters = $activeFilters;

        return $this;
    }

    public function getActiveFilters(): ?array
    {
        return $this->activeFilters;
    }

    public function setFilters(FilterCollection $filters): self
    {
        $this->filters = $filters;

        return $this;
    }

    public function getFilters(): ?FilterCollection
    {
        return $this->filters;
    }
}
