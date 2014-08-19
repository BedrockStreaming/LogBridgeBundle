<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

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

    private function getParser()
    {
        return new Config\Parser($this->getMockedRouter());
    }

    private function getConfig()
    {
        return [
            'environments' => [
                'dev' => [
                    'filter_un',
                    'filter_trois'
                ],
                'prod' => 'all'
            ],
            'filters' => [
                'filter_un' => [
                    'route' =>  'route_name',
                    'method' => 'all',
                    'status' => 'all'
                ],
                'filter_deux' => [
                    'route' =>  'route_name',
                    'method' => 'all',
                    'status' => [404, 422, 500]
                ],
                'filter_trois' => [
                    'route' =>  'route_name',
                    'method' => ['PUT', 'POST'],
                    'status' => 'all'
                ],
                'filter_quatre' => [
                    'route' =>  'route_name',
                    'method' => ['PUT'],
                    'status' => [200]
                ]
            ]
        ];
    }


    public function testValidConfig()
    {
        $config = $this->getConfig();

        $this
            ->if($parser = $this->getParser())
            ->then
                ->object($configuration = $parser->parse($config))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Configuration')
                ->array($configuration->getEnvironments())
                    ->hasSize(count($config['environments']))
                    ->hasKeys(array_keys($config['environments']))
                ->object($collection = $configuration->getFilters())
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\FilterCollection')
                ->integer($collection->count())
                    ->isEqualTo(count($config['filters']))
        ;
    }


    public function testInvalidConfig()
    {
        $config = [
            'environments' => [
                'dev' => [
                    'filter_un',
                    'filter_trois'
                ],
                'prod' => 'azerty'
            ]
        ];

        $this
            ->if($parser = $this->getParser())
            ->then
                ->exception(function() use($parser, $config) {
                    $parser->parse($config);
                })
                ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\ParseException')
        ;

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
                ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\ParseException')
        ;

    }


}