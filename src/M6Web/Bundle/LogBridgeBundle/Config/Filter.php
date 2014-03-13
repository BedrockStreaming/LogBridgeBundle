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
     * __construct
     *
     * @param string $name name Filter name
     */
    public function __construct($name)
    {
        $this->name = $name;
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

}
