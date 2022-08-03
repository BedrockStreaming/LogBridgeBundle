<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Config;

class Filter extends atoum
{
    public function testFilter(): void
    {
        $this
            ->if($filter = new Config\Filter('filter_name'))
            ->then
                ->string($filter->getName())
                    ->isEqualTo('filter_name')
                ->object($filter->setRoutes(['filter_route']))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Filter::class)
                ->array($filter->getRoutes())
                    ->isEqualTo(['filter_route'])
                ->object($filter->setMethod(null))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Filter::class)
                ->variable($filter->getMethod())
                    ->isEqualTo(null)
                ->object($filter->setStatus([200, 301]))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Filter::class)
                ->array($filter->getStatus())
                    ->isIdenticalTo([200, 301])
        ;
    }
}
