<?php

namespace M6Web\Bundle\LogBridgeBundle\Config;

/**
 * Filter
 */
class Filter
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $route;

    /**
     * @var mixed
     */
    private $method;

    /**
     * @var mixed
     */
    private $status;

    /**
     * @var mixed
     */
    private $level;

    /**
     * @var array
     */
    private $options;

    /**
     * __construct
     *
     * @param string $name name Filter name
     */
    public function __construct($name)
    {
        $this->name = $name;
        $this->route = null;
        $this->method = null;
        $this->status = null;
        $this->level = null;
        $this->options = [];
    }

    /**
     * getName
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setRoute
     *
     * @param string $route Route
     *
     * @return Filter
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * getRoute
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * setMethod
     *
     * @param mixed $method Method
     *
     * @return Filter
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * getMethod
     *
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * setStatus
     *
     * @param mixed $status Http code status
     *
     * @return Filter
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * getStatus
     *
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * setLevel
     *
     * @param mixed $level Log level
     *
     * @return Filter
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * getLevel
     *
     * @return mixed
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * set filter options
     *
     * @return Filter
     */
    public function setOptions(array $options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * get filter options
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
