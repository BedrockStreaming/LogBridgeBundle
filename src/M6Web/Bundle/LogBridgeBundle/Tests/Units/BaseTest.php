<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units;

use atoum;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;

/**
 * Base Class Unit test
 */
class BaseTest extends atoum
{
    protected function getMockedRouterCollection(): object
    {
        $collection = new \mock\Symfony\Component\Routing\RouteCollection();
        $collection->getMockController()->get = fn($name) => $name != 'invalid_route' ? new Route('/path') : null;
        $collection->getMockController()->all = [
            'fake_url' => new Route('/fake_url'),
            'fake_second_url' => new Route('/fake_second_url'),
            'excluded_route' => new Route('/excluded_route')
        ];

        return $collection;
    }

    protected function getMockedRouter(): object
    {
        $this->mockGenerator->orphanize('__construct');
        $router = new \mock\Symfony\Component\Routing\Router();
        $routerCollection = $this->getMockedRouterCollection();

        $router->getMockController()->getRouteCollection = $routerCollection;
        $router->getMockController()->generate = fn($name, $parameters = [], $referenceType = false) => $name;

        $router->getMockController()->match = fn($pathinfo) => [];
        $router->getMockController()->setContext = function(RequestContext $context) { return; };
        $router->getMockController()->getContext = null;

        return $router;
    }
}
