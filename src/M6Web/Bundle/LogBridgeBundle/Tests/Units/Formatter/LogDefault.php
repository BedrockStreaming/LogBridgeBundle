<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Formatter;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

use atoum;
use M6Web\Bundle\LogBridgeBundle\Tests\MockSecurityToken;
use M6Web\Bundle\LogBridgeBundle\Tests\MockSecurityContext;
use Symfony\Component\Security\Core\User\User;
use M6Web\Bundle\LogBridgeBundle\Formatter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * LogContentFormatter
 */
class LogDefault extends atoum
{
    const ENVIRONMENT = 'test';


    private function createProvider($environment = self::ENVIRONMENT, array $ignores = array('php-auth-pw'), $prefix = '')
    {
        $provider = new Formatter\LogDefault($environment, $ignores, $prefix);

        return $provider;
    }

    private function createContext()
    {
        $token = new MockSecurityToken();
        $token->setUser(new User('test', 'password'));
        $context = new MockSecurityContext();
        $context->setToken($token);

        return $context;
    }

    public function testProvider()
    {
        $request  = new Request();
        $response = new Response();
        $context  = $this->createContext();
        $route    = $request->get('_route');
        $method   = $request->getMethod();
        $status   = $response->getStatusCode();

        $this
            ->if($provider = $this->createProvider())
            ->then
            ->object($provider->setContext($context))
                ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Formatter\LogDefault')
            ->string($provider->getLogContent($request, $response))
                ->contains('HTTP 1.0 200')
                ->contains('Cache-Control')
                ->contains('Etag')
                ->contains("Request\n")
                ->contains("Response\n")
            ->array($logContext = $provider->getLogContext($request, $response))
                ->hasSize(6)
                ->hasKeys(['environment', 'route', 'method', 'status', 'user', 'key'])
            ->string($logContext['environment'])
                ->isEqualTo(self::ENVIRONMENT)
            ->variable($logContext['route'])
                ->isNull()
            ->string($logContext['method'])
                ->isEqualTo($method)
            ->integer($logContext['status'])
                ->isEqualTo($status)
            ->string($logContext['user'])
                ->isEqualTo($context->getToken()->getUsername())
            ->string($logContext['key'])
                ->isEqualTo(sprintf('%s.%s.%s.%s', self::ENVIRONMENT, $route, $method, $status))
        ;

    }

}
