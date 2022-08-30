<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Config;

class FilterCollection extends atoum
{
    private function createFilterRoutes(string $name, array $routes, ?array $method, ?array $status): Config\Filter
    {
        $filter = new Config\Filter($name);
        $filter
            ->setRoutes($routes)
            ->setMethod($method)
            ->setStatus($status);

        return $filter;
    }

    private function createFilterRoute(string $name, string $route, ?array $method, ?array $status): Config\Filter
    {
        $filter = new Config\Filter($name);
        $filter
            ->setRoute($route)
            ->setMethod($method)
            ->setStatus($status);

        return $filter;
    }

    public function testCollection(): void
    {
        $filters = [];
        $filters[] = $this->createFilterRoutes('filter_un', ['get_clip'], ['all'], ['all']);
        $filters[] = $this->createFilterRoutes('filter_deux', ['put_clip'], ['PUT'], ['all']);
        $filters[] = $this->createFilterRoutes('filter_trois', ['put_clip'], ['PUT'], [400, 404, 422, 500]);
        $filters[] = $this->createFilterRoute('filter_quatre', 'get_clip', ['all'], ['all']);
        $filters[] = $this->createFilterRoute('filter_cinq', 'put_clip', ['PUT'], [400, 404, 422, 500]);
        $filterSix = $this->createFilterRoutes('filter_six', ['post_clip'], ['POST'], [400, 404, 422, 500]);

        $this
            ->if($collection = new Config\FilterCollection($filters))
            ->then
                ->integer($collection->count())
                    ->isEqualTo(5)
                ->object($filterUn = $collection->getByName('filter_un'))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Filter::class)
                ->variable($collection->getByName('filter_invalid'))
                    ->isNull()
                ->object($filterIt = $collection->get(0))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Filter::class)
                ->string($filterUn->getName())
                    ->isEqualTo($filterIt->getName())
                ->array($collection->getKeys())
                    ->hasSize($collection->count())
                ->object($collection->add($filterSix))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\FilterCollection::class)
                ->object($collection->getByName($filterSix->getName()))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Filter::class)
                ->string($collection->getKey(5))
                    ->isEqualTo($filterSix->getName())
        ;
    }
}
