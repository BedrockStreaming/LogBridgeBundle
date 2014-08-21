<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Formatter;

require_once __DIR__ . '/../../../../../../../vendor/autoload.php';

use atoum;
use Symfony\Component\Security\Core\User\User;
use M6Web\Bundle\LogBridgeBundle\Formatter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * DefaultFormatter
 */
class DefaultFormatter extends atoum
{
    const ENVIRONMENT = 'test';

    private function getUser()
    {
        return new User('test', 'password');
    }

    private function getMockedToken(User $user = null)
    {
        $user  = $user ?: $this->getUser();
        $token = new \mock\Symfony\Component\Security\Core\Authentication\TokenInterface();

        $token->getMockController()->getUsername    = $user->getUsername();
        $token->getMockController()->getUser        = $user;
        $token->getMockController()->__toString     = $user->getUsername();
        $token->getMockController()->getCredentials = 'test';

        return $token;
    }

    private function getMockedSecurityContext()
    {
        $token   = $this->getMockedToken();
        $context = new \mock\Symfony\Component\Security\Core\SecurityContextInterface();

        $context->getMockController()->getToken = $token;
        $context->getMockController()->isGranted = function($attributes, $object = null) { return true; };

        return $context;
    }

    private function createProvider($environment = self::ENVIRONMENT, array $ignores = array('php-auth-pw'), $prefix = '')
    {
        $provider = new Formatter\DefaultFormatter($environment, $ignores, $prefix);

        return $provider;
    }

    public function testProvider()
    {
        $request  = new Request();
        $response = new Response('Body content response');
        $context  = $this->getMockedSecurityContext();
        $route    = $request->get('_route');
        $method   = $request->getMethod();
        $status   = $response->getStatusCode();

        $this
            ->if($provider = $this->createProvider())
            ->then
            ->object($provider->setContext($context))
                ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Formatter\DefaultFormatter')
            ->string($provider->getLogContent($request, $response, []))
                ->contains('HTTP 1.0 200')
                ->contains('Cache-Control')
                ->contains('Etag')
                ->contains("Request\n")
                ->contains("Response\n")
            ->string($provider->getLogContent($request, $response, ['response_body' => true]))
                ->contains("Response body\n")
                ->contains($response->getContent())
            ->array($logContext = $provider->getLogContext($request, $response, []))
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
