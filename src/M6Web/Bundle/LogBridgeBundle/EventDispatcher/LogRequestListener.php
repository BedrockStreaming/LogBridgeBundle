<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\EventDispatcher;

use M6Web\Bundle\LogBridgeBundle\Formatter\FormatterInterface;
use M6Web\Bundle\LogBridgeBundle\Matcher\MatcherInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;

/**
 * LogRequestListener
 */
class LogRequestListener
{
    protected ?LoggerInterface $logger;

    protected ?MatcherInterface $matcher;

    protected FormatterInterface $contentFormatter;

    public function __construct(FormatterInterface $contentFormatter)
    {
        $this->contentFormatter = $contentFormatter;
        $this->logger = null;
        $this->matcher = null;
    }

    public function onKernelTerminate(ResponseEvent $event): void
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

    public function setLogger(LoggerInterface $logger): self
    {
        $this->logger = $logger;

        return $this;
    }

    public function setMatcher(MatcherInterface $matcher): self
    {
        $this->matcher = $matcher;

        return $this;
    }
}
