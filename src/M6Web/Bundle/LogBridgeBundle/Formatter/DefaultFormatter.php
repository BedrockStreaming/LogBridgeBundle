<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Formatter;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

/**
 * DefaultFormatter
 */
class DefaultFormatter implements FormatterInterface
{
    protected ?TokenStorageInterface $tokenStorage = null;

    /**
     * __construct
     *
     * @param string   $environment   env
     * @param string[] $ignoreHeaders Array list from ignore header info
     * @param string   $prefixKey     Log context prefix key
     */
    public function __construct(
        protected string $environment,
        protected array $ignoreHeaders = [],
        protected string $prefixKey = ''
    ) {
    }

    /**
     * Format parameters as tree
     *
     * @param array<string, mixed> $parameters
     */
    protected function formatParameters(array $parameters): string
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
     */
    public function getLogContent(Request $request, Response $response, array $options): string
    {
        $requestHeaders = $this->getFilteredHeaders($request);
        $requestContent = "Request\n------------------------\n";

        foreach ($requestHeaders as $name => $headerValue) {
            $value = is_array($headerValue) ? $headerValue[0] : $headerValue;
            $requestContent .= str_pad((string) $name, 20, ' ', STR_PAD_RIGHT).': '.$value."\n";
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
            && $options['post_parameters'] === true
            && in_array($request->getMethod(), ['POST', 'PUT', 'PATCH'])) {
            $responseContent .= "Post parameters\n";
            $responseContent .= $this->formatParameters($request->request->all());
        }

        // Render response body content
        if (array_key_exists('response_body', $options)
            && $options['response_body'] === true) {
            $responseContent .= "Response body\n------------------------\n";
            $responseContent .= $response->getContent()."\n";
        }

        return sprintf(
            "%s------------------------\n%s",
            $requestContent,
            $responseContent
        );
    }

    public function getLogContext(Request $request, Response $response, array $options): array
    {
        /** @var string $route */
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

    protected function getUsername(): string
    {
        if (!$this->tokenStorage || !$token = $this->tokenStorage->getToken()) {
            return '';
        }

        // compatibility Symfony < 6
        if (!method_exists($token, 'getUserIdentifier')
            && method_exists($token, 'getUsername')) {
            return $token->getUsername();
        }

        return $token->getUserIdentifier();
    }

    /**
     * @return array<int|string, array<int, string|null>|string|null>
     */
    protected function getFilteredHeaders(Request $request): array
    {
        return array_diff_key($request->headers->all(), array_flip($this->ignoreHeaders));
    }

    public function setTokenStorage(TokenStorageInterface $tokenStorage): self
    {
        $this->tokenStorage = $tokenStorage;

        return $this;
    }

    /**
     * @param string[] $ignoreHeaders
     */
    public function setIgnoreHeaders(array $ignoreHeaders): self
    {
        $this->ignoreHeaders = $ignoreHeaders;

        return $this;
    }

    /**
     * @return string[]
     */
    public function getIgnoreHeaders(): array
    {
        return $this->ignoreHeaders;
    }

    public function setPrefixKey(string $prefixKey): self
    {
        $this->prefixKey = $prefixKey;

        return $this;
    }

    public function getPrefixKey(): string
    {
        return $this->prefixKey;
    }
}
