<?php

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

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
     * @var TokenStorageInterface
     */
    protected $tokenStorage;

    /**
     * __construct
     *
     * @param string $environment   env
     * @param array  $ignoreHeaders Array list from ignore header info
     * @param string $prefixKey     Log context prefix key
     */
    public function __construct($environment, array $ignoreHeaders = [], $prefixKey = '')
    {
        $this->environment = $environment;
        $this->ignoreHeaders = $ignoreHeaders;
        $this->prefixKey = $prefixKey;
        $this->tokenStorage = null;
    }

    /**
     * Format parameters as tree
     *
     * @return string
     */
    protected function formatParameters(array $parameters)
    {
        $tree = new \RecursiveTreeIterator(new \RecursiveArrayIterator($parameters));
        $tree->setPrefixPart(\RecursiveTreeIterator::PREFIX_LEFT, ' ');
        $tree->setPrefixPart(\RecursiveTreeIterator::PREFIX_MID_HAS_NEXT, '│ ');
        $tree->setPrefixPart(\RecursiveTreeIterator::PREFIX_END_HAS_NEXT, '├ ');
        $tree->setPrefixPart(\RecursiveTreeIterator::PREFIX_END_LAST, '└ ');

        $content = '';

        foreach ($tree as $key => $value) {
            $content .= $tree->getPrefix().$key.' : '.$tree->getEntry()."\n";
        }

        return $content;
    }

    /**
     * getLogContent
     *
     * @param Request  $request  Request service
     * @param Response $response Response service
     * @param array    $options  Request options
     *
     * @return string
     */
    public function getLogContent(Request $request, Response $response, array $options)
    {
        $requestHeaders = $this->getFilteredHeaders($request);
        $requestContent = "Request\n------------------------\n";

        foreach ($requestHeaders as $name => $values) {
            $requestContent .= str_pad($name, 20, ' ', STR_PAD_RIGHT).': '.$values[0]."\n";
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

        // Render post parameters
        if (array_key_exists('post_parameters', $options)
            && $options['post_parameters'] == true
            && in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'])) {
            $responseContent .= "Post parameters\n";
            $responseContent .= $this->formatParameters($request->request->all());
        }

        // Render response body content
        if (isset($options['response_body'])) {
            $responseContent .= "Response body\n------------------------\n";
            $responseContent .= $response->getContent()."\n";
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
     * @param array    $options  Request options
     *
     * @return array
     */
    public function getLogContext(Request $request, Response $response, array $options)
    {
        $route = $request->get('_route');
        $method = $request->getMethod();
        $status = $response->getStatusCode();

        $context = [
            'environment' => $this->environment,
            'route' => $route,
            'method' => $method,
            'status' => $status,
            'user' => $this->getUsername(),
            'key' => sprintf('%s.%s.%s.%s', $this->environment, $route, $method, $status),
            'uri' => $request->getUri(),
        ];

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
        if ($this->tokenStorage && $this->tokenStorage->getToken()) {
            return $this->tokenStorage->getToken()->getUsername();
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
     * @param TokenStorageInterface $tokenStorage User security token storage
     *
     * @return LogRequestListener
     */
    public function setTokenStorage(TokenStorageInterface $tokenStorage)
    {
        $this->tokenStorage = $tokenStorage;

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
