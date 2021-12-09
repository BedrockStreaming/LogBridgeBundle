<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Formatter;

use atoum;
use Symfony\Component\Security\Core\User\InMemoryUser;
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
    const USERNAME = 'test-username';
    const PASSWORD = 'test-password';

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

    private function createProvider($environment = self::ENVIRONMENT, array $ignores = array('php-auth-pw'), $prefix = '')
    {
        $provider = new Formatter\DefaultFormatter($environment, $ignores, $prefix);

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

        $this
            ->if($provider = $this->createProvider())
            ->then
            ->object($provider->setTokenStorage($tokenstorage))
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

    public function testPostProvider()
    {
        $post = [
            'postVar1' => 'value un',
            'postVar2' => 'value 2',
            'programs' => [
                'id'    => 42,
                'title' => 'Non mais Allo quoi'
            ]
        ];


        $request = new Request([], $post, [], [], [], ['REQUEST_METHOD' => 'POST']);

        $response      = new Response('Body content response');
        $tokenstorage  = $this->getMockedTokenStorage();

        $this
            ->if($provider = $this->createProvider())
            ->then
            ->object($provider->setTokenStorage($tokenstorage))
                ->isInstanceOf('M6Web\Bundle\LogBridgeBundle\Formatter\DefaultFormatter')
            ->string($provider->getLogContent($request, $response, ['post_parameters' => true]))
                ->contains('HTTP 1.0 200')
                ->contains('Cache-Control')
                ->contains('Etag')
                ->contains("Request\n")
                ->contains("Response\n")
                ->contains('Post parameters')
                ->contains('Post parameters')
                ->contains('postVar2 : value 2')
                ->contains('└ title : Non mais Allo quoi')
        ;
    }
}
