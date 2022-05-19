<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

use Symfony\Component\Routing\RouterInterface;

/**
 * Parser
 */
class Parser
{
    private RouterInterface $router;

    private ?FilterParser $filterParser;

    /**
     * __construct
     *
     * @param RouterInterface $router Router service
     */
    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
        $this->filterParser = null;
    }

    protected function createFilterCollection(array $filters): FilterCollection
    {
        $collection = new FilterCollection();

        foreach ($filters as $name => $config) {
            $collection->add($this->getFilterParser()->parse($name, $config));
        }

        return $collection;
    }

    /**
     * parse
     * Load Log Request filter configuration
     *
     * @internal param array $config Config
     *
     * @return Configuration
     */
    public function parse(array $params)
    {
        $config = new Configuration();
        $filters = new FilterCollection();

        if (!empty($params['filters'])) {
            $filters = $this->createFilterCollection($params['filters']);
        }

        if (!empty($params['active_filters'])) {
            $config->setActiveFilters($params['active_filters']);
        }

        $config->setFilters($filters);

        return $config;
    }

    public function getFilterParser(): FilterParser
    {
        if ($this->filterParser === null) {
            $this->filterParser = new FilterParser($this->router);
        }

        return $this->filterParser;
    }
}
