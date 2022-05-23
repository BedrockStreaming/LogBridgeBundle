<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Filter
 */
class Filter
{
    private string $name;

    private mixed $route;

    private mixed $method;

    private mixed $status;

    private mixed $level;

    private array $options;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->route = null;
        $this->method = null;
        $this->status = null;
        $this->level = null;
        $this->options = [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setRoute(mixed $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getRoute(): mixed
    {
        return $this->route;
    }

    public function setMethod(mixed $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod(): mixed
    {
        return $this->method;
    }

    public function setStatus(mixed $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getStatus(): mixed
    {
        return $this->status;
    }

    public function setLevel(mixed $level): self
    {
        $this->level = $level;

        return $this;
    }

    public function getLevel(): mixed
    {
        return $this->level;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }
}
