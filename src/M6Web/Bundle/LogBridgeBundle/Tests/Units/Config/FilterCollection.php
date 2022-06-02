<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

use atoum;  
use M6Web\Bundle\LogBridgeBundle\Config;

class FilterCollection extends atoum
{
    private function createFilter(string $name, string $route, ?array $method, ?array $status): Config\Filter
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
        $filters[] = $this->createFilter('filter_un', 'get_clip', ['all'], ['all']);
        $filters[] = $this->createFilter('filter_deux', 'put_clip', ['PUT'], ['all']);
        $filters[] = $this->createFilter('filter_trois', 'put_clip', ['PUT'], [400, 404, 422, 500]);

        $filterQuatre =$this->createFilter('filter_quatre', 'post_clip', ['POST'], [400, 404, 422, 500]);

        $this
            ->if($collection = new Config\FilterCollection($filters))
            ->then
                ->integer($collection->count())
                    ->isEqualTo(3)
                ->object($filterUn = $collection->getByName('filter_un'))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->variable($collection->getByName('filter_invalid'))
                    ->isNull()
                ->object($filterIt = $collection->get(0))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($filterUn->getName())
                    ->isEqualTo($filterIt->getName())
                ->array($collection->getKeys())
                    ->hasSize($collection->count())
                ->object($collection->add($filterQuatre))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\FilterCollection')
                ->object($collection->getByName($filterQuatre->getName()))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($collection->getKey(3))
                    ->isEqualTo($filterQuatre->getName())
        ;
    }
}
