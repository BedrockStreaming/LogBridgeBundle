<?php

/**
 * TestLogMatcher
 *
 * This class has been auto-generated
 * by the M6Web LogBridgeBundle.
 */
class TestLogMatcher implements M6Web\Bundle\LogBridgeBundle\Matcher\MatcherInterface
{
    /**
     * @var array
     * List of compiled filters
     */
    private $filters = [
        'get_clip.GET.200' => [
            'options' => [
                'response_body' => true,
                'post_parameters' => true,
            ],
            'level' => 'info',
        ],
        'get_clip.PUT.200' => [
            'options' => [
                'response_body' => true,
                'post_parameters' => true,
            ],
            'level' => 'info',
        ],
        'all.PUT.200' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.201' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.202' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.203' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.204' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.205' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.206' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.207' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.208' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.209' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.210' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.211' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.212' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.213' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.214' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.215' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.216' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.217' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.218' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.219' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.220' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.221' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.222' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.223' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.224' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.225' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.226' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.227' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.228' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.229' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.230' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.231' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.232' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.233' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.234' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.235' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.236' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.237' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.238' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.239' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.240' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.241' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.242' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.243' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.244' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.245' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.246' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.247' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.248' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.249' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.250' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.251' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.252' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.253' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.254' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.255' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.256' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.257' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.258' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.259' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.260' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.261' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.262' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.263' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.264' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.265' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.266' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.267' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.268' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.269' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.270' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.271' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.272' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.273' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.274' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.275' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.276' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.277' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.278' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.279' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.280' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.281' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.282' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.283' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.284' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.285' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.286' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.287' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.288' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.289' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.290' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.291' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.292' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.293' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.294' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.295' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.296' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.297' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.298' => [
            'options' => [],
            'level' => 'info',
        ],
        'all.PUT.299' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.450' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.451' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.459' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.460' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.461' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.462' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.463' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.464' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.465' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.466' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.467' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.468' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.469' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.470' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.471' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.472' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.473' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.474' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.475' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.476' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.477' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.478' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.479' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.480' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.481' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.482' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.483' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.484' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.485' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.486' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.487' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.488' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.489' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.490' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.491' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.492' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.493' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.494' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.495' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.496' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.497' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.498' => [
            'options' => [],
            'level' => 'info',
        ],
        'delete_clip.DELETE.499' => [
            'options' => [],
            'level' => 'info',
        ]
    ];

    /**
     * getPositiveMatcher
     *
     * @param string  $route       Route name
     * @param string  $method      Method name
     * @param integer $status      Http code status
     *
     * @return array
     */
    private function getPositiveMatcher($route, $method, $status)
    {
        return [
            [$route, $method, $status],
            [$route, $method, 'all'],
            [$route, 'all', $status],
            ['all', $method, $status],
            [$route, 'all', 'all'],
            ['all', 'all', $status],
            ['all', $method, 'all'],
            ['all', 'all', 'all']
        ];
    }

    /**
     * match
     *
     * @param string  $route       Route name
     * @param string  $method      Method name
     * @param integer $status      Http code status
     *
     * @return boolean
     */   
    public function match($route, $method, $status)
    {
        if ($filterKey = $this->getMatchFilterKey($route, $method, $status)) {
            return true;
        }

        return false;
    }

    /**
     * generate filter key
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return string
     */
    public function generateFilterKey($route, $method, $status)
    {
        return sprintf('%s.%s.%s', $route, $method, $status);
    }

    /**
     * Get filter options
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return array
     */
    public function getOptions($route, $method, $status)
    {
        if ($filterKey = $this->getMatchFilterKey($route, $method, $status)) {
            return $this->filters[$filterKey]['options'];
        }

        return [];
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
        if ($filterKey = $this->getMatchFilterKey($route, $method, $status)) {
            return $this->filters[$filterKey]['level'];
        }

        return 'info';
    }

    /**
     * addFilter
     *
     * @param string $filterKey Filter key
     * @param string $level     Filter Log level
     * @param array  $options   Filter options
     *
     * @return MatcherInterface
     */
    public function addFilter($filterKey, $level = 'info', array $options = [])
    {
        if (!$this->hasFilter($filterKey)) {
            $this->filters[$filterKey]            = [];
            $this->filters[$filterKey]['options'] = $options;
            $this->filters[$filterKey]['level']   = $level;
        }

        return $this;
    }

    /**
     * setFilters
     *
     * @param array   $filters   Filter list
     * @param boolean $overwrite Overwrite current filter
     *
     * @return MatcherInterface
     */
    public function setFilters(array $filters, $overwrite = false)
    {
        if ($overwrite) {
            $this->filters = $filters;
        } else {
            foreach ($filters as $filterKey => $filter) {

                if (!isset($filter['level'])) {
                    $filter['level'] = 'info';
                }

                if (!isset($filter['options'])) {
                    $filter['options'] = [];
                }

                $this->addFilter($filterKey, $filter['level'], $filter['options']);
            }
        }

        return $this;
    }

    /**
     * getFilters
     *
     * @return array
     */
    public function getFilters()
    {
        return $this->filters;
    }

    /**
     * hasFilter
     *
     * @param string $filterKey Filter key
     *
     * @return boolean
     */
    public function hasFilter($filterKey)
    {
        return array_key_exists($filterKey, $this->filters);
    }

    /**
     * get an filter key matched with arguments
     *
     * @param string  $route  Route name
     * @param string  $method Method name
     * @param integer $status Http code status
     *
     * @return bool|string
     */
    public function getMatchFilterKey($route, $method, $status)
    {
        if (!empty($this->filters)) {
            foreach ($this->getPositiveMatcher($route, $method, $status) as $rms) {
                $filterKey = $this->generateFilterKey($rms[0], $rms[1], $rms[2]);
                if ($this->hasFilter($filterKey)) {
                    return $filterKey;
                }
            }
        }

        return false;
    }
}
