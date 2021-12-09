<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Formatter;

use atoum;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Core\User\User;
use M6Web\Bundle\LogBridgeBundle\Formatter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * ExceptionFormatter
 */
class ExceptionFormatter extends atoum
{
    const ENVIRONMENT = 'test';
    const USERNAME = 'test-username';
    const PASSWORD = 'test-password';

    /**
     * @var string
     */
    private $requestExceptionAttribute;

    /**
     * @param string $method
     */
    public function beforeTestMethod($method)
    {
        $this->requestExceptionAttribute = 'LogBridgeBundle_'.time();
    }

    private function getUser()
    {
        if (class_exists(User::class)) {
            return new User(self::USERNAME, self::PASSWORD);
        }

        return new InMemoryUser(self::USERNAME, self::PASSWORD);
    }

    private function getMockedToken()
    {
        $usernameMethod = 'getUserIdentifier';
        if (method_exists('Symfony\Component\Security\Core\Authentication\Token\TokenInterface', 'getUsername')) {
            // compatibility Symfony < 6
            $usernameMethod = 'getUsername';
        }

        $token = new \mock\Symfony\Component\Security\Core\Authentication\Token\TokenInterface();
        $token->getMockController()->$usernameMethod = self::USERNAME;
        $token->getMockController()->getUser = $this->getUser();
        $token->getMockController()->__toString = self::USERNAME;

        return $token;
    }

    private function getMockedTokenStorage()
    {
        $token   = $this->getMockedToken();
        $context = new \mock\Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

        $context->getMockController()->getToken = $token;

        return $context;
    }

    private function createProvider($environment = self::ENVIRONMENT, array $ignores = ['php-auth-pw'], $prefix = '')
    {
        $provider = new Formatter\ExceptionFormatter($environment, $ignores, $prefix);
        $provider->setRequestExceptionAttribute($this->requestExceptionAttribute);

        return $provider;
    }

    public function testProvider()
    {
        $request       = new Request();
        $response      = new Response('Body content response');
        $tokenstorage  = $this->getMockedTokenStorage();
        $route         = $request->get('_route');
        $method        = $request->getMethod();
        $status        = $response->getStatusCode();
        $exception     = new \Exception('Test exception');

        $this
            ->given(
                $request->attributes->add([$this->requestExceptionAttribute => $exception])
            )
            ->if($provider = $this->createProvider())
            ->then
            ->object($provider->setTokenStorage($tokenstorage))
                ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Formatter\ExceptionFormatter')
            ->string($provider->getLogContent($request, $response, []))
                ->contains('HTTP 1.0 200')
                ->contains('Cache-Control')
                ->contains('Etag')
                ->contains("Request\n")
                ->contains("Response\n")
                ->contains('Exception message (1) :')
                ->contains($exception->getMessage())
                ->contains('Exception trace (1) :')
                ->contains($exception->getTraceAsString())
            ->string($provider->getLogContent($request, $response, ['response_body' => true]))
                ->contains("Response body\n")
                ->contains($response->getContent())
                ->contains('Exception message (1) :')
                ->contains($exception->getMessage())
                ->contains('Exception trace (1) :')
                ->contains($exception->getTraceAsString())
            ->array($logContext = $provider->getLogContext($request, $response, []))
                ->hasSize(7)
                ->hasKeys(['environment', 'route', 'method', 'status', 'user', 'key', 'uri'])
            ->string($logContext['environment'])
                ->isEqualTo(self::ENVIRONMENT)
            ->variable($logContext['route'])
                ->isNull()
            ->string($logContext['method'])
                ->isEqualTo($method)
            ->integer($logContext['status'])
                ->isEqualTo($status)
            ->string($logContext['user'])
                ->isEqualTo(self::USERNAME)
            ->string($logContext['key'])
                ->isEqualTo(sprintf('%s.%s.%s.%s', self::ENVIRONMENT, $route, $method, $status))
        ;
    }

    public function testProviderExceptionsDepth()
    {
        $request       = new Request();
        $response      = new Response('Body content response');
        $tokenstorage  = $this->getMockedTokenStorage();
        $exception3    = new \Exception('Test: first exception thrown.');
        $exception2    = new \Exception('Test: second exception thrown.', null, $exception3);
        $exception1    = new \Exception('Test: third exception thrown.', null, $exception2);

        $this
            ->given(
                $request->attributes->add([$this->requestExceptionAttribute => $exception1])
            )
            ->if($provider = $this->createProvider())
            ->then
            ->object($provider->setTokenStorage($tokenstorage))
                ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Formatter\ExceptionFormatter')
            ->string($provider->getLogContent($request, $response, []))
                ->contains('Exception message (1) :')
                ->contains($exception1->getMessage())
                ->contains('Exception trace (1) :')
                ->contains($exception1->getTraceAsString())
                ->contains('Exception message (2) :')
                ->contains($exception2->getMessage())
                ->contains('Exception trace (2) :')
                ->contains($exception2->getTraceAsString())
                ->contains('Exception message (3) :')
                ->contains($exception3->getMessage())
                ->contains('Exception trace (3) :')
                ->contains($exception3->getTraceAsString())
        ;
    }

    public function testTypeErrorException()
    {
        $request = new Request();
        $exception = new \TypeError('Test: TypeError exception thrown.');

        $this
            ->given(
                $request->attributes->add([$this->requestExceptionAttribute => $exception])
            )
            ->if($provider = $this->createProvider())
            ->then
            ->object($provider->setTokenStorage($this->getMockedTokenStorage()))
            ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Formatter\ExceptionFormatter')
            ->string($provider->getLogContent($request, new Response('Body content response'), []))
            ->contains('Exception message (1) :')
            ->contains($exception->getMessage())
            ->contains('Exception trace (1) :')
            ->contains($exception->getTraceAsString())
        ;
    }
}
