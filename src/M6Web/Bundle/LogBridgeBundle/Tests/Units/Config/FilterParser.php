<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

use M6Web\Bundle\LogBridgeBundle\Tests\Units\BaseTest;
use M6Web\Bundle\LogBridgeBundle\Config;

/**
 * FilterParser
 */
class FilterParser extends BaseTest
{
    private function getParser(): Config\FilterParser
    {
        return new Config\FilterParser($this->getMockedRouter());
    }

    private function getConfig(): array
    {
        return [
            'filter_un' => [
                'routes' =>  ['route_name'],
                'method' => null,
                'status' => null
            ],
            'filter_deux' => [
                'routes' =>  ['route_name'],
                'method' => null,
                'status' => [404, 422, 500]
            ],
            'filter_trois' => [
                'routes' =>  ['route_name'],
                'method' => ['PUT', 'POST'],
                'status' => null
            ],
            'filter_quatre' => [
                'routes' =>  ['route_name'],
                'method' => ['PUT'],
                'status' => [200]
            ],
            'filter_route_invalid' => [
                'routes' => ['invalid_route'],
                'method' => ['PUT'],
                'status' => [200]
            ],
            'filter_method_invalid' => [
                'routes' => ['route_name'],
                'method' => 'PUT',
                'status' => [200]
            ],
            'filter_status_invalid' => [
                'routes' => ['route_name'],
                'method' => ['PUT'],
                'status' => 200
            ],
            'filter_route_excluded' => [
                'routes' => ['route_name', '!excluded_route'],
                'method' => ['PUT'],
                'status' => [200]
            ],
            'filter_route_excluded_all' => [
                'routes' => ['!excluded_route'],
                'method' => ['PUT'],
                'status' => [200]
            ],
            'filter_route_simple' => [
                'route' => 'route_name',
                'method' => ['GET'],
                'status' => [200]
            ],
            'filter_undefined_route_or_routes' => [
                'method' => ['PUT'],
                'status' => 200
            ],
        ];
    }

    public function testValidParse(): void
    {
        $config = $this->getConfig();

        $this
            ->if($parser = $this->getParser())
            ->then
                ->object($filter = $parser->parse('filter_un', $config['filter_un']))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($filter->getName())
                    ->isIdenticalTo('filter_un')
                ->array($filter->getRoutes())
                    ->isIdenticalTo($config['filter_un']['routes'])
                ->variable($filter->getMethod())
                    ->isIdenticalTo($config['filter_un']['method'])
                ->variable($filter->getStatus())
                    ->isIdenticalTo($config['filter_un']['status'])

                ->object($filter = $parser->parse('filter_deux', $config['filter_deux']))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($filter->getName())
                    ->isIdenticalTo('filter_deux')
                ->array($filter->getRoutes())
                    ->isIdenticalTo($config['filter_deux']['routes'])
                ->variable($filter->getMethod())
                    ->isIdenticalTo($config['filter_deux']['method'])
                ->variable($filter->getStatus())
                    ->isIdenticalTo($config['filter_deux']['status'])

                ->object($filter = $parser->parse('filter_trois', $config['filter_trois']))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($filter->getName())
                    ->isIdenticalTo('filter_trois')
                ->array($filter->getRoutes())
                    ->isIdenticalTo($config['filter_trois']['routes'])
                ->variable($filter->getMethod())
                    ->isIdenticalTo($config['filter_trois']['method'])
                ->variable($filter->getStatus())
                    ->isIdenticalTo($config['filter_trois']['status'])

                ->object($filter = $parser->parse('filter_quatre', $config['filter_quatre']))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($filter->getName())
                    ->isIdenticalTo('filter_quatre')
                ->array($filter->getRoutes())
                    ->isIdenticalTo($config['filter_quatre']['routes'])
                ->variable($filter->getMethod())
                    ->isIdenticalTo($config['filter_quatre']['method'])
                ->variable($filter->getStatus())
                    ->isIdenticalTo($config['filter_quatre']['status'])

                ->object($filter = $parser->parse('filter_route_simple', $config['filter_route_simple']))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($filter->getName())
                    ->isIdenticalTo('filter_route_simple')
                ->string($filter->getRoute())
                    ->isIdenticalTo($config['filter_route_simple']['route'])
                ->variable($filter->getMethod())
                    ->isIdenticalTo($config['filter_route_simple']['method'])
                ->variable($filter->getStatus())
                    ->isIdenticalTo($config['filter_route_simple']['status'])
        ;

    }

    public function testUndefinedRouteOrRoutes(): void
    {
        $config = $this->getConfig()['filter_undefined_route_or_routes'];

        $this
            ->if($parser = $this->getParser())
            ->then
            ->exception(function() use ($parser, $config) {
                $parser->parse('filter_undefined_route_or_routes', $config);
            })
            ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\ParseException::class)
            ->message
            ->contains('Undefined "route(s)", "method" or "status" parameter from filter "filter_undefined_route_or_routes"')
        ;
    }

    public function testInvalidRoute(): void
    {
        $config = $this->getConfig()['filter_route_invalid'];

        $this
            ->if($parser = $this->getParser())
            ->then
                ->exception(function() use ($parser, $config) {
                    $parser->parse('filter_route_invalid', $config);
                })
                ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\ParseException::class)
                ->message
                    ->contains('Undefined route')
        ;
    }

    public function testInvalidMethod(): void
    {
        $config = $this->getConfig()['filter_method_invalid'];

        $this
            ->if($parser = $this->getParser())
            ->then
                ->exception(function() use ($parser, $config) {
                    $parser->parse('filter_method_invalid', $config);
                })
                ->isInstanceOf(\TypeError::class)
                ->message
                    ->contains('must be of type ?array, string given')
        ;
    }

    public function testInvalidStatus(): void
    {
        $config = $this->getConfig()['filter_status_invalid'];

        $this
            ->if($parser = $this->getParser())
            ->then
                ->exception(function() use ($parser, $config) {
                    $parser->parse('filter_status_invalid', $config);
                })
                ->isInstanceOf(\TypeError::class)
                ->message
                    ->contains('must be of type ?array, int given')
        ;
    }

    public function testRouteExcluded(): void
    {
        $config = $this->getConfig()['filter_route_excluded'];

        $this
            ->if($parser = $this->getParser())
            ->then
            ->object($filter = $parser->parse('filter_route_excluded', $config))
            ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
            ->string($filter->getName())
            ->isIdenticalTo('filter_route_excluded')
            ->array($filter->getRoutes())
            ->isIdenticalTo(['route_name'])
            ->variable($filter->getMethod())
            ->isIdenticalTo($config['method'])
            ->variable($filter->getStatus())
            ->isIdenticalTo($config['status']);
    }

    public function testRouteExcludedAll(): void
    {
        $config = $this->getConfig()['filter_route_excluded_all'];

        $this
            ->if($parser = $this->getParser())
            ->then
            ->object($filter = $parser->parse('filter_route_excluded_all', $config))
            ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
            ->string($filter->getName())
            ->isIdenticalTo('filter_route_excluded_all')
            ->array($filter->getRoutes())
            ->isIdenticalTo(['fake_url', 'fake_second_url'])
            ->variable($filter->getMethod())
            ->isIdenticalTo($config['method'])
            ->variable($filter->getStatus())
            ->isIdenticalTo($config['status']);
    }
}
