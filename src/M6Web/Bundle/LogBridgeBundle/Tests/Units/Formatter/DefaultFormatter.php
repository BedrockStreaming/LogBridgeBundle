<?php

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\Formatter;

use atoum;
use Symfony\Component\Security\Core\User\InMemoryUser;
use Symfony\Component\Security\Core\User\User;
use M6Web\Bundle\LogBridgeBundle\Formatter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * DefaultFormatter
 */
class DefaultFormatter extends atoum
{
    private const ENVIRONMENT = 'test';
    private const USERNAME = 'test-username';
    private const PASSWORD = 'test-password';

    private function getUser(): UserInterface
    {
        if (class_exists(User::class)) {
            return new User(self::USERNAME, self::PASSWORD);
        }

        return new InMemoryUser(self::USERNAME, self::PASSWORD);
    }

    private function getMockedToken()
    {
        $usernameMethod = 'getUserIdentifier';
        if (!method_exists(\Symfony\Component\Security\Core\Authentication\Token\TokenInterface::class, $usernameMethod) &&
            method_exists(\Symfony\Component\Security\Core\Authentication\Token\TokenInterface::class, 'getUsername')) {
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

    private function createProvider(string $environment = self::ENVIRONMENT, array $ignores = array('php-auth-pw'), string $prefix = ''): Formatter\DefaultFormatter
    {
        return new Formatter\DefaultFormatter($environment, $ignores, $prefix);
    }

    public function testProvider(): void
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
                ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Formatter\DefaultFormatter::class)
            ->string($provider->getLogContent($request, $response, []))
                ->contains('HTTP 1.0 200')
                ->contains('Cache-Control')
                ->contains('Etag')
                ->contains("Request\n")
                ->contains("Response\n")
            ->string($provider->getLogContent($request, $response, ['response_body' => true]))
                ->contains("Response body\n")
                ->contains($response->getContent())
            ->string($provider->getLogContent($request, $response, ['response_body' => false]))
                ->notContains("Response body\n")
                ->notContains($response->getContent())
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

    public function testPostProvider(): void
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
                ->isInstanceOf(\M6Web\Bundle\LogBridgeBundle\Formatter\DefaultFormatter::class)
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
