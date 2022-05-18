<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * FilterCollection
 */
class FilterCollection implements \Iterator
{
    /** @var int */
    protected $iterator;

    /** @var array */
    protected $keys;

    /** @var array */
    protected $values;

    /**
     * __construct
     *
     * @internal param array $filters Filters
     */
    public function __construct(array $items = [])
    {
        $this->iterator = 0;
        $this->keys = [];
        $this->values = [];

        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * add
     *
     * @internal param \M6Web\Bundle\LogBridgeBundle\Config\Filter $filter Filter
     */
    public function add(Filter $item): FilterCollection
    {
        if (!in_array($item->getName(), $this->keys)) {
            $this->keys[] = $item->getName();
        }

        $this->values[$item->getName()] = $item;

        return $this;
    }

    /**
     * getByName
     *
     * @param string $name
     *
     * @return Filter
     */
    public function getByName($name)
    {
        if (!isset($this->values[$name])) {
            return null;
        }

        return $this->values[$name];
    }

    /**
     * remove
     *
     * @param Filter $filter Filter
     */
    public function remove(Filter $filter): bool
    {
        if ($key = array_search($filter->getName(), $this->keys)) {
            unset($this->keys[$key]);
            unset($this->values[$filter->getName()]);

            return true;
        }

        return false;
    }

    /**
     * get
     * Get item
     *
     * @param int $iterator
     */
    public function get($iterator): mixed
    {
        if ($key = $this->getKey($iterator)) {
            return $this->values[$key];
        }

        return null;
    }

    /**
     * getName
     * Define filter name with iterator position
     *
     * @param string $iterator
     */
    public function getKey($iterator): string
    {
        return isset($this->keys[$iterator]) ? $this->keys[$iterator] : '';
    }

    /**
     * getkeys
     */
    public function getKeys(): array
    {
        return $this->keys;
    }

    /**
     * current
     *
     * @return Filter
     */
    public function current(): mixed
    {
        return $this->get($this->iterator);
    }

    /**
     * key
     */
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

    /**
     * valid
     */
    public function valid(): bool
    {
        return isset($this->keys[$this->iterator]);
    }

    /**
     * count
     */
    public function count(): int
    {
        return count($this->values);
    }
}
