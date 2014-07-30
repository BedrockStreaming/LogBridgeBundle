<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units;

use atoum;
use Symfony\Component\Routing\RequestContext;

/**
 * Base Class Unit test
 */
class BaseTest extends atoum
{
    protected function getMockedRouterCollection()
    {
        $collection = new \mock\Symfony\Component\Routing\RouteCollection();
        $collection->getMockController()->get = function($name) {
            return $name != 'invalid_route' ? true : false;
        };

        return $collection;
    }

    protected function getMockedRouter()
    {
        $this->mockGenerator->orphanize('__construct');
        $router = new \mock\Symfony\Component\Routing\Router();
        $routerCollection = $this->getMockedRouterCollection();

        $router->getMockController()->getRouteCollection = $routerCollection;
        $router->getMockController()->generate = function($name, $parameters = [], $referenceType = false) {
            return $name;
        };

        $router->getMockController()->match = function($pathinfo) { return []; };
        $router->getMockController()->setContext = function(RequestContext $context) { return; };
        $router->getMockController()->getContext = null;

        return $router;
    }

}
