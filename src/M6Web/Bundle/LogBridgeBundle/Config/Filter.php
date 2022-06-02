<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Filter
 */
class Filter
{
    private ?string $route = null;

    private ?array $method = null;

    private ?array $status = null;

    private ?string $level = null;

    private array $options = [];

    public function __construct(private string $name)
    {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setRoute(?string $route): self
    {
        $this->route = $route;

        return $this;
    }

    public function getRoute(): ?string
    {
        return $this->route;
    }

    public function setMethod(?array $method): self
    {
        $this->method = $method;

        return $this;
    }

    public function getMethod(): ?array
    {
        return $this->method;
    }

    public function setStatus(?array $status): self
    {
        $this->status = $status;

        return $this;
    }

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
