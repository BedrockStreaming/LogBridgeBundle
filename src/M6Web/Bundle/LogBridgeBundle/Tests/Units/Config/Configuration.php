<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Config;

use atoum;
use M6Web\Bundle\LogBridgeBundle\Config;

class Configuration extends atoum
{
    private function getFilters(): Config\FilterCollection
    {
        $collection = new Config\FilterCollection();

        $filter = new Config\Filter('active_filters_one');
        $filter
            ->setRoute('route_name')
            ->setMethod(['GET', 'POST'])
            ->setStatus(['all']);

        $collection->add($filter);

        $filter = new Config\Filter('active_filters_two');
        $filter
            ->setRoute('route_name_two')
            ->setMethod(['PUT', 'POST'])
            ->setStatus([200]);

        $collection->add($filter);

        $filter = new Config\Filter('active_filters_three');
        $filter
            ->setRoute('route_name_three')
            ->setMethod(['all'])
            ->setStatus([422, 404, 500]);

        $collection->add($filter);

        return $collection;
    }

    private function getActiveFilters(): array
    {
        return [
            'active_filters_one',
            'active_filters_two',
            'active_filters_three'
        ];
    }

    public function testConfiguration(): void
    {
        $activeFilters = $this->getActiveFilters();

        $this
            ->if($configuration = new Config\Configuration())
            ->then
                ->variable($configuration->getActiveFilters())
                    ->isNull()
                ->object($configuration->setActiveFilters($activeFilters))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Configuration::class)
                ->array($configuration->getActiveFilters())
                    ->hasSize(3)
                    ->hasKeys(array_keys($activeFilters))
                ->variable($configuration->getFilters())
                    ->isNull()
                ->object($configuration->setFilters($this->getFilters()))
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\Configuration::class)
                ->object($collection = $configuration->getFilters())
                    ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Config\FilterCollection::class);
    }
}
