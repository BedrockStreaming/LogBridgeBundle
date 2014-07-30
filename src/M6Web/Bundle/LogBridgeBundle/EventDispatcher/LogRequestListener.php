<?php

namespace M6Web\Bundle\LogBridgeBundle\EventDispatcher;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use M6Web\Bundle\LogBridgeBundle\Matcher\MatcherInterface;
use M6Web\Bundle\LogBridgeBundle\Formatter\FormatterInterface;

/**
 * LogRequestListener
 */
class LogRequestListener
{
    /**
     * LoggerInterface
     */
    protected $logger;

    /**
     * @var MatcherInterface
     */
    protected $matcher;

    /**
     * @var LogContentFormatter
     */
    protected $contentFormatter;

    /**
     * Construct
     *
     * @param FormatterInterface $logger Logger
     */
    public function __construct(FormatterInterface $contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
        $this->logger          = null;
        $this->matcher         = null;
    }

    /**
     * onKernelTerminate
     *
     * @param FilterResponseEvent $event Event
     */
    public function onKernelTerminate($event)
    {
        $request  = $event->getRequest();
        $response = $event->getResponse();
        $route    = $request->get('_route');
        $method   = $request->getMethod();
        $status   = $response->getStatusCode();

        if ($this->matcher->match($route, $method, $status)) {
            $this->logger->info(
                $this->contentFormatter->getLogContent($request, $response),
                $this->contentFormatter->getLogContext($request, $response)
            );
        }
    }

    /**
     * setLogger
     *
     * @param LoggerInterface $logger Logger
     *
     * @return LogRequestListener
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;

        return $this;
    }

    /**
     * setMatcher
     *
     * @param MatcherInterface $matcher Matcher
     *
     * @return LogRequestListener
     */
    public function setMatcher(MatcherInterface $matcher)
    {
        $this->matcher = $matcher;

        return $this;
    }

}
