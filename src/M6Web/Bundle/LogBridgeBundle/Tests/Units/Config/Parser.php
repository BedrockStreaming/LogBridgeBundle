<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

use M6Web\Bundle\LogBridgeBundle\Tests\Units\BaseTest;
use M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Parser
 */
class Parser extends BaseTest
{
    private function getRouter()
    {
        return new MockRouter();
    }

    private function getParser(): Config\Parser
    {
        return new Config\Parser($this->getMockedRouter());
    }

    private function getConfig(): array
    {
        return [
            'active_filters' => [
                'filter_un',
                'filter_trois'
            ],
            'filters' => [
                'filter_un' => [
                    'route' =>  'route_name',
                    'method' => null,
                    'status' => null
                ],
                'filter_deux' => [
                    'route' =>  'route_name',
                    'method' => null,
                    'status' => [404, 422, 500]
                ],
                'filter_trois' => [
                    'route' =>  'route_name',
                    'method' => ['PUT', 'POST'],
                    'status' => null
                ],
                'filter_quatre' => [
                    'route' =>  'route_name',
                    'method' => ['PUT'],
                    'status' => [200]
                ]
            ]
        ];
    }


    public function testValidConfig(): void
    {
        $config = $this->getConfig();

        $this
            ->if($parser = $this->getParser())
            ->then
                ->object($configuration = $parser->parse($config))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Configuration::class)
                ->array($configuration->getActiveFilters())
                    ->hasSize(is_countable($config['active_filters']) ? count($config['active_filters']) : 0)
                    ->hasKeys(array_keys($config['active_filters']))
                ->object($collection = $configuration->getFilters())
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\FilterCollection::class)
                ->integer($collection->count())
                    ->isEqualTo(is_countable($config['filters']) ? count($config['filters']) : 0)
        ;
    }


    public function testInvalidConfig(): void
    {
        $config = [
            'filters' => [
                'filter_route_invalid' => [
                    'route' => 'invalid_route',
                    'method' => ['PUT'],
                    'status' => [200]
                ],
                'filter_method_invalid' => [
                    'route' => 'route_name',
                    'method' => 'PUT',
                    'status' => [200]
                ],
                'filter_status_invalid' => [
                    'route' => 'route_name',
                    'method' => ['PUT'],
                    'status' => 200
                ]
            ]
        ];

        $this
            ->if($parser = $this->getParser())
            ->then
                ->exception(function() use($parser, $config) {
                    $parser->parse($config);
                })
                ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\ParseException::class)
        ;

    }
}
