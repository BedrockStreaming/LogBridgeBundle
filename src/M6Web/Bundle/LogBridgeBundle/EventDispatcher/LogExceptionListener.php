<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\EventDispatcher;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * LogExceptionListener overload here to send the entire exception to log bridge.
 */
class LogExceptionListener
{
    public function __construct(protected string $requestExceptionAttribute)
    {
    }

    /**
     * React to an exception to give error message to log bridge
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $request = $event->getRequest();
        $request->setRequestFormat('json');
        $request->attributes->add([$this->requestExceptionAttribute => $event->getThrowable()]);
    }
}
