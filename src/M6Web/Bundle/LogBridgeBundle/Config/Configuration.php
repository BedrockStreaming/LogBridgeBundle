<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Class Configuration
 */
class Configuration
{
    private ?FilterCollection $filters = null;

    /** @var string[] */
    private ?array $activeFilters = null;

    /**
     * @param string[] $activeFilters
     */
    public function setActiveFilters(array $activeFilters): self
    {
        $this->activeFilters = $activeFilters;

        return $this;
    }

    /**
     * @return string[]|null
     */
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
