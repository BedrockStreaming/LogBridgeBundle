<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

use Symfony\Component\Routing\RouterInterface;

/**
 * Parser
 */
class Parser
{
    private ?FilterParser $filterParser = null;

    public function __construct(private RouterInterface $router)
    {
    }

    /**
     * @param array<string, array{
     *     route?: string,
     *     routes?: string[],
     *     method?: string[],
     *     status?: int[],
     *     level?: string,
     *     options?: array{post_parameters?: bool, response_body?: bool}
     * }> $filters
     */
    protected function createFilterCollection(array $filters): FilterCollection
    {
        $collection = new FilterCollection();

        foreach ($filters as $name => $config) {
            $collection->add($this->getFilterParser()->parse($name, $config));
        }

        return $collection;
    }

    /**
     * Load Log Request filter configuration
     *
     * @param array{
     *     filters?: array<string, array{
     *         route?: string,
     *         routes?: string[],
     *         method?: string[],
     *         status?: int[],
     *         level?: string,
     *         options?: array{post_parameters?: bool, response_body?: bool}
     *     }> ,
     *     active_filters?: string[]
     * } $params
     */
    public function parse(array $params): Configuration
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
