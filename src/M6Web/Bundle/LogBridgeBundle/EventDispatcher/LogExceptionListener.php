<?php

namespace M6Web\Bundle\LogBridgeBundle\EventDispatcher;

use Symfony\Component\HttpKernel\Event\ExceptionEvent;

/**
 * LogExceptionListener overload here to send the entire exception to log bridge.
 */
class LogExceptionListener
{
    /** @var string */
    protected $requestExceptionAttribute;

    /**
     * @param string $requestExceptionAttribute
     */
    public function __construct($requestExceptionAttribute)
    {
        $this->requestExceptionAttribute = $requestExceptionAttribute;
    }

    /**
     * React to an exception to give error message to log bridge
     */
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        $request = $event->getRequest();
        $request->setRequestFormat('json');
        $request->attributes->add([$this->requestExceptionAttribute => $exception]);
    }
}
