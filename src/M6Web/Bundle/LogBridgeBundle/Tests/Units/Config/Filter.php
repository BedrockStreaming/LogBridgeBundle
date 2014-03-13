<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

use atoum;
use M6Web\Bundle\LogBridgeBundle\Config;


class Filter extends atoum
{

    public function testFilter()
    {
        $this
            ->if($filter = new Config\Filter('filter_name'))
            ->then
                ->string($filter->getName())
                    ->isEqualTo('filter_name')
                ->object($filter->setRoute('filter_route'))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($filter->getRoute())
                    ->isEqualTo('filter_route')
                ->object($filter->setMethod('all'))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->string($filter->getMethod())
                    ->isEqualTo('all')
                ->object($filter->setStatus([200, 301]))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Filter')
                ->array($filter->getStatus())
                    ->isIdenticalTo([200, 301])
        ;
    }

}
