<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\EventDispatcher;

use M6Web\Bundle\LogBridgeBundle\Matcher\BuilderInterface;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * BuilderEvent
 */
class BuilderEvent extends Event
{
    private BuilderInterface $builder;

    private array $config;

    public function __construct(BuilderInterface $builder, array $config = [])
    {
        $this->builder = $builder;
        $this->config = $config;
    }

    public function setBuilder(BuilderInterface $builder): self
    {
        $this->builder = $builder;

        return $this;
    }

    public function getBuilder(): BuilderInterface
    {
        return $this->builder;
    }

    public function setConfig(array $config): self
    {
        $this->config = $config;

        return $this;
    }

    public function getConfig(): array
    {
        return $this->config;
    }
}
