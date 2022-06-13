<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Abstract class AbstractType
 */
abstract class AbstractType implements TypeInterface
{
    protected string $pattern;

    /**
     * Match with config status
     */
    public function match(string $config): bool
    {
        return preg_match($this->getPattern(), $config) === 1;
    }

    /**
     * Get status list
     *
     * @throws \Exception transform method must be return an array
     */
    final public function getStatus(string $config): array
    {
        if ($this->isExclude($config)) {
            $config = substr($config, 1);
        }

        return $this->transform($config);
    }

    /**
     * Match with config status
     */
    final public function isExclude(string $config): bool
    {
        return str_contains($config, '!');
    }

    abstract protected function getPattern(): string;

    /**
     * Transform config to status list
     *
     * @return array<int, string|int>
     */
    abstract protected function transform(string $config): array;
}
