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
    public function __construct(private BuilderInterface $builder, private array $config = [])
    {
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
