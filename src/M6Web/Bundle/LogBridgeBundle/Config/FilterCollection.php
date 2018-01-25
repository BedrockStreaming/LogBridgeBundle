<?php

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * FilterCollection
 */
class FilterCollection implements \Iterator
{
    /**
     * @var int
     */
    protected $iterator;

    /**
     * @var array
     */
    protected $keys;

    /**
     * @var array
     */
    protected $values;

    /**
     * __construct
     *
     * @param array $items
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
     * @param Filter $item
     *
     * @internal param \M6Web\Bundle\LogBridgeBundle\Config\Filter $filter Filter
     *
     * @return FilterCollection
     */
    public function add(Filter $item)
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
     *
     * @return bool
     */
    public function remove(Filter $filter)
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
     *
     * @return mixed
     */
    public function get($iterator)
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
     *
     * @return string
     */
    public function getKey($iterator)
    {
        return isset($this->keys[$iterator]) ? $this->keys[$iterator] : '';
    }

    /**
     * getkeys
     *
     * @return array
     */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
     * current
     *
     * @return Filter
     */
    public function current()
    {
        return $this->get($this->iterator);
    }

    /**
     * key
     *
     * @return int
     */
    public function key()
    {
        return $this->iterator;
    }

    /**
     * next
     */
    public function next()
    {
        $this->iterator++;
    }

    /**
     * rewind
     */
    public function rewind()
    {
        $this->iterator = 0;
    }

    /**
     * valid
     *
     * @return bool
     */
    public function valid()
    {
        return isset($this->keys[$this->iterator]);
    }

    /**
     * count
     *
     * @return int
     */
    public function count()
    {
        return count($this->values);
    }
}
