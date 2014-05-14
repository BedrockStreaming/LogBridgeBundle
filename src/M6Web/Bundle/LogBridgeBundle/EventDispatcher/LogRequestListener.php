<?php

namespace M6Web\Bundle\LogBridgeBundle\EventDispatcher;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;
use M6Web\Bundle\LogBridgeBundle\Matcher\MatcherInterface;

/**
 * LogRequestListener
 */
class LogRequestListener
{
    /**
     * @var string
     */
    protected $environment;

    /**
     * LoggerInterface
     */
    protected $logger;

    /**
     * @var MatcherInterface
     */
    protected $matcher;

    /**
     * @var SecurityContextInterface
     */
    protected $context;

    /**
     * @var string
     */
    protected $prefixKey;

    /**
     * Construct
     *
     * @param LoggerInterface $logger Logger
     */
    public function __construct($environment)
    {
        $this->environment = $environment;
        $this->logger      = null;
        $this->matcher     = null;
        $this->context     = null;
        $this->prefixKey   = '';
    }

    /**
     * onKernelTerminate
     *
     * @param FilterResponseEvent $event Event
     */
    public function onKernelTerminate($event)
    {
        $request     = $event->getRequest();
        $response    = $event->getResponse();

        $route       = $request->get('_route');
        $method      = $request->getMethod();
        $statusCode  = $response->getStatusCode();

        if ($this->matcher->match($route, $method, $statusCode)) {
            $this->logger->info(
                $this->createContent($request, $response),
                $this->createContext($route, $method, $statusCode)
            );
        }
    }

    /**
     * createContent
     * Format log content
     *
     * @param Request  $request  Request
     * @param Response $response Response
     *
     * @return string
     */
    protected function createContent(Request $request, Response $response)
    {
        $requestHeaders = array_diff_key($request->headers->all(), array_flip(array('php-auth-pw')));
        $requestContent = "Request\n------------------------\n";
        $requestContent .= $request->getUri() ."\n\n";

        foreach ($requestHeaders as $name => $values) {
            $requestContent .= str_pad($name, 20, ' ', STR_PAD_RIGHT) .': '. $values[0] ."\n";
        }

        $responseContent = sprintf(
            "Response\n------------------------\nHTTP %s %d\n",
            $response->getProtocolVersion(),
            $response->getStatusCode()
        );

        $responseContent .= sprintf("%s%s\n", str_pad('Age:', 15), $response->getAge());
        $responseContent .= sprintf("%s%s\n", str_pad('Etag:', 15), $response->getEtag());
        $responseContent .= sprintf("%s%s\n", str_pad('Vary:', 15), implode(', ', $response->getVary()));
        $responseContent .= $response->headers->__toString();

        return sprintf(
            "%s------------------------\n%s",
            $requestContent,
            $responseContent
        );
    }
 
    /**
     * createContext
     *
     * @param string  $route  Route name
     * @param string  $method Http method
     * @param integer $status Http status code
     *
     * @return array
     */
    protected function createContext($route, $method, $status)
    {
        $context = array(
            'environment' => $this->environment,
            'route'       => $route,
            'method'      => $method,
            'status'      => $status,
            'user'        => $this->getUsername(),
            'key'         => sprintf('%s.%s.%s.%s', $this->environment, $route, $method, $status)
        );

        if ($this->prefixKey) {
            $context['key'] = sprintf('%s.%s', $this->prefixKey, $context['key']);
        }

        return $context;
    }

    /**
     * getUsername
     *
     * @return string
     */
    protected function getUsername()
    {
        if ($this->context && $this->context->getToken()) {
            return $this->context->getToken()->getUsername();
        }

        return '';
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

    /**
     * setContext
     *
     * @param SecurityContextInterface $context User security context
     *
     * @return LogRequestListener
     */
    public function setContext(SecurityContextInterface $context)
    {
        $this->context = $context;

        return $this;
    }

    /**
     * setPrefixKey
     *
     * @param string $prefixKey
     *
     * @return LogRequestListener
     */
    public function setPrefixKey($prefixKey)
    {
        $this->prefixKey = $prefixKey;

        return $this;
    }

    /**
     * getPrefixKey
     *
     * @return string
     */
    public function getPrefixKey()
    {
        return $this->prefixKey;
    }

}
