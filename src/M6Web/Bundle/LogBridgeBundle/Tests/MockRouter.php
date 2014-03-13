<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Routing\RequestContext;

/**
 * MockRouter
 */
class MockRouter implements RouterInterface
{

    public function getRouteCollection()
    {
        return new MockRouteCollection();
    }

    public function generate($name, $parameters = array(), $referenceType = self::ABSOLUTE_PATH)
    {
        return $name;
    }

    public function match($pathinfo)
    {
        return [];
    }

    public function setContext(RequestContext $context)
    {

    }

    public function getContext()
    {
        return null;
    }

}
