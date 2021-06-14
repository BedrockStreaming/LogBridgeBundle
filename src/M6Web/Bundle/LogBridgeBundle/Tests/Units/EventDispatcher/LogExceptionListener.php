<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Tests\Units\EventDispatcher;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class LogExceptionListener
{
    public function testOnKernelExceptionCall()
    {
        $this
            ->given(
                $request = Request::create('/path'),
                $exception = new \Exception()
            )
            ->if($this->newTestedInstance('foo-attribute'))
            ->when($this->testedInstance->onKernelException(new ExceptionEvent(
                new \mock\Symfony\Component\HttpKernel\HttpKernelInterface,
                $request,
                HttpKernelInterface::MAIN_REQUEST,
                $exception
            )))
            ->then
                ->array($request->attributes->all())
                    ->hasKey('foo-attribute')
                ->object($request->attributes->get('foo-attribute'))
                    ->isIdenticalTo($exception)
        ;
    }
}
