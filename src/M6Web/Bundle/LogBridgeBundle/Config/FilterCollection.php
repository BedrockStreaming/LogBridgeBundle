<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * @implements \Iterator<int, Filter>
 */
class FilterCollection implements \Iterator
{
    protected int $iterator = 0;

    /** @var string[]  */
    protected array $keys = [];

    /** @var array<string, Filter> */
    protected array $values = [];

    /**
     * @param Filter[] $items
     */
    public function __construct(array $items = [])
    {
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    public function add(Filter $item): FilterCollection
    {
        if (!in_array($item->getName(), $this->keys, true)) {
            $this->keys[] = $item->getName();
        }

        $this->values[$item->getName()] = $item;

        return $this;
    }

    public function getByName(string $name): ?Filter
    {
        return $this->values[$name] ?? null;
    }

    public function remove(Filter $filter): bool
    {
        if ($key = array_search($filter->getName(), $this->keys, true)) {
            unset($this->keys[$key], $this->values[$filter->getName()]);

            return true;
        }

        return false;
    }

    public function get(int $iterator): ?Filter
    {
        if ($key = $this->getKey($iterator)) {
            return $this->values[$key];
        }

        return null;
    }

    /**
     * Define filter name with iterator position
     */
    public function getKey(int $iterator): string
    {
        return $this->keys[$iterator] ?? '';
    }

    /**
     * @return string[]
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    public function current(): ?Filter
    {
        return $this->get($this->iterator);
    }

    public function key(): int
    {
        return $this->iterator;
    }

    public function next(): void
    {
        $this->iterator++;
    }

    public function rewind(): void
    {
        $this->iterator = 0;
    }

    public function valid(): bool
    {
        return isset($this->keys[$this->iterator]);
    }

    public function count(): int
    {
        return count($this->values);
    }
}
