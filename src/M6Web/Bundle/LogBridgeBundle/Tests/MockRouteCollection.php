<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests;

require_once __DIR__ . '/../../../../../vendor/autoload.php';


class MockRouteCollection
{
    public function get($name)
    {
        return $name != 'invalid_route' ? true : false;
    }

}
