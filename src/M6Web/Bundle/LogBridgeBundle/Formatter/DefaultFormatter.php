<?php

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContextInterface;

/**
 * DefaultFormatter
 */
class DefaultFormatter implements FormatterInterface
{
    /**
     * @var string
     */
    protected $environment;

    /**
     * @var array
     */
    protected $ignoreHeaders;

    /**
     * @var string
     */
    protected $prefixKey;

    /**
     * @var SecurityContextInterface
     */
    protected $context;

    /**
     * __construct
     *
     * @param string $environment   env
     * @param array  $ignoreHeaders Array list from ignore header info
     * @param string $prefixKey     Log context prefix key
     */
    public function __construct($environment, array $ignoreHeaders = array(), $prefixKey = '')
    {
        $this->environment   = $environment;
        $this->ignoreHeaders = $ignoreHeaders;
        $this->prefixKey     = $prefixKey;
        $this->context       = null;
    }

    /**
     * getLogContent
     *
     * @param Request  $request  Request service
     * @param Response $response Response service
     *
     * @return string
     */
    public function getLogContent(Request $request, Response $response, array $options)
    {
        $requestHeaders = $this->getFilteredHeaders($request);
        $requestContent = "Request\n------------------------\n";

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

        if (isset($options['response_body'])) {
            $responseContent .= "Response body\n------------------------\n";
            $responseContent .= $response->getContent() ."\n";
        }

        return sprintf(
            "%s------------------------\n%s",
            $requestContent,
            $responseContent
        );
    }

    /**
     * getLogContext
     *
     * @param Request  $request  Request service
     * @param Response $response Response service
     *
     * @return array
     */
    public function getLogContext(Request $request, Response $response, array $options)
    {
        $route   = $request->get('_route');
        $method  = $request->getMethod();
        $status  = $response->getStatusCode();

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
     * getFilteredHeaders
     *
     * @param Request $request Request service
     *
     * @return array
     */
    protected function getFilteredHeaders(Request $request)
    {
        return array_diff_key($request->headers->all(), array_flip($this->ignoreHeaders));
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
     * setIgnoreHeaders
     *
     * @param array $ignoreHeaders Array list of ignore header info
     *
     * @return $this
     */
    public function setIgnoreHeaders(array $ignoreHeaders)
    {
        $this->ignoreHeaders = $ignoreHeaders;

        return $this;
    }

    /**
     * getIgnoreHeaders
     *
     * @return array
     */
    public function getIgnoreHeaders()
    {
        return $this->ignoreHeaders;
    }

    /**
     * setPrefixKey
     *
     * @param string $prefixKey Prefix key
     *
     * @return $this
     */
    public function setPrefixKey($prefixKey)
    {
        $this->prefixKey = $prefixKey;
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
