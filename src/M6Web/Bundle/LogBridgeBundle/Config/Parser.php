<?php

namespace M6Web\Bundle\LogBridgeBundle\Config;

use Symfony\Component\Routing\RouterInterface;

/**
 * Parser
 */
class Parser
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var FilterParser
     */
    private $filterParser;

    /**
     * __construct
     *
     * @param RouterInterface $router Router service
     */
    public function __construct(RouterInterface $router)
    {
        $this->router       = $router;
        $this->filterParser = null;
    }

    /**
     * createFilterCollection
     *
     * @param array $filters Filters configuration
     *
     * @return FilterCollection
     */
    protected function createFilterCollection(array $filters)
    {
        $collection = new FilterCollection();

        foreach ($filters as $name => $config) {
            $collection->add($this->getFilterParser()->parse($name, $config));
        }

        return $collection;
    }

    /**
     * createEnvironmentCollection
     *
     * @param array            $environments Environments Map
     * @param FilterCollection $filters      Filters
     *
     * @throws ParseException
     * @return array
     */
    protected function createEnvironmentCollection(array $environments, FilterCollection $filters)
    {
        $envMap = [];

        foreach ($environments as $name => $filterList) {
            if (!is_array($filterList)) {
                if (!is_null($filterList)) {
                    throw new ParseException(sprintf('Invalid parameter value "route" : "%s"', $filterList));
                }

                $envMap[$name] = $filters->getkeys();
            } else {
                $envMap[$name] = $filterList;
            }
        }

        return $envMap;
    }

    /**
     * parse
     * Load Log Request filter configuration
     *
     * @param array $params
     *
     * @internal param array $config Config
     * @return Configuration
     */
    public function parse(array $params)
    {
        $config  = new Configuration();
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

    /**
     * getFilterParser
     *
     * @return FilterParser
     */
    public function getFilterParser()
    {
        if (!$this->filterParser) {
            $this->filterParser = new FilterParser($this->router);
        }

        return $this->filterParser;
    }

}
