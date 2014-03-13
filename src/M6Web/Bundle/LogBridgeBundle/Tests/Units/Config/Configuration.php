<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

use atoum;  
use M6Web\Bundle\LogBridgeBundle\Config;


class Configuration extends atoum
{
    private function getEnvironment()
    {
        return [
            'dev' => [
                'alias_un',
                'alias_deux'
            ],
            'prod' => [
                'alias_un',
                'alias_trois'
            ]
        ];
    }

    private function getFilters()
    {
        $collection = new Config\FilterCollection();

        $filter = new Config\Filter('alias_un');
        $filter
            ->setRoute('route_name')
            ->setMethod(['GET', 'POST'])
            ->setStatus('all');

        $collection->add($filter);


        $filter = new Config\Filter('alias_deux');
        $filter
            ->setRoute('route_name_deux')
            ->setMethod(['PUT', 'POST'])
            ->setStatus('200');

        $collection->add($filter);


        $filter = new Config\Filter('alias_trois');
        $filter
            ->setRoute('route_name_trois')
            ->setMethod(['all'])
            ->setStatus([422, 404, 500]);

        $collection->add($filter);

        return $collection;
    }


    public function testConfiguration()
    {
        $environments = $this->getEnvironment();


        $this
            ->if($configuration = new Config\Configuration())
            ->then
                ->array($configuration->getEnvironments())
                    ->isEmpty()
                ->object($configuration->setEnvironments($environments))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Configuration')
                ->array($configuration->getEnvironments())
                    ->hasSize(2)
                    ->hasKeys(array_keys($environments))
                ->variable($configuration->getFilters())
                    ->isNull()
                ->object($configuration->setFilters($this->getFilters()))
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\Configuration')
                ->object($collection = $configuration->getFilters())
                    ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Config\FilterCollection');
    }

}
