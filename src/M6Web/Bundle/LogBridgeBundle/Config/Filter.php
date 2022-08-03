<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Filter
 */
class Filter
{
    private ?array $routes = [];

    /** @var string[]|null */
    private ?array $method = null;

    /** @var int[]|null */
    private ?array $status = null;

    private ?string $level = null;

    /** @var array{post_parameters?: bool, response_body?: bool} */
    private array $options = [];

    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setRoutes(?array $routes): self
    {
        $this->routes = $routes;

        return $this;
    }

    public function getRoutes(): ?array
    {
        return $this->routes;
    }

    /**
     * @param string[]|null $method
     */
    public function setMethod(?array $method): self
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return string[]|null
     */
    public function getMethod(): ?array
    {
        return $this->method;
    }

    /**
     * @param int[]|null $status
     */
    public function setStatus(?array $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return int[]|null
     */
    public function getStatus(): ?array
    {
        return $this->status;
    }

    public function setLevel(?string $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLevel(): ?string
    {
        return $this->level;
    }

    /**
     * @param array{post_parameters?: bool, response_body?: bool} $options
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    /**
     * @return array{post_parameters?: bool, response_body?: bool}
     */
    public function getOptions(): array
    {
        return $this->options;
    }
}
