<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\EventDispatcher;

use M6Web\Bundle\LogBridgeBundle\Formatter\FormatterInterface;
use M6Web\Bundle\LogBridgeBundle\Matcher\MatcherInterface;
use Psr\Log\LoggerInterface;

/**
 * LogRequestListener
 */
class LogRequestListener
{
    /** @var LoggerInterface */
    protected $logger;

    /** @var MatcherInterface */
    protected $matcher;

    /** @var FormatterInterface */
    protected $contentFormatter;

    /**
     * Construct
     *
     * @internal param \Psr\Log\LoggerInterface $logger Logger
     */
    public function __construct(FormatterInterface $contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
        $this->logger = null;
        $this->matcher = null;
    }

    /**
     * onKernelTerminate
     *
     * @param FilterResponseEvent $event Event
     */
    public function onKernelTerminate($event)
    {
        $request = $event->getRequest();
        $response = $event->getResponse();
        $route = $request->get('_route');
        $method = $request->getMethod();
        $status = $response->getStatusCode();
        $level = $this->matcher->getLevel($route, $method, $status);
        $options = $this->matcher->getOptions($route, $method, $status);

        if ($this->matcher->match($route, $method, $status)) {
            $this->logger->$level(
                $this->contentFormatter->getLogContent($request, $response, $options),
                $this->contentFormatter->getLogContext($request, $response, $options)
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
