<?php

namespace M6Web\Bundle\LogBridgeBundle\EventDispatcher;

use Symfony\Component\EventDispatcher\Event;
use M6Web\Bundle\LogBridgeBundle\Matcher\BuilderInterface;

/**
 * BuilderEvent
 */
class BuilderEvent extends Event
{
    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @var array
     */
    private $config;

    /**
     * __construct
     *
     * @param BuilderInterface $builder Builder
     * @param array            $config  Config
     */
    public function __construct(BuilderInterface $builder, array $config = array())
    {
        $this->builder = $builder;
        $this->config  = $config;
    }

    /**
     * setBuilder
     *
     * @param BuilderInterface $builder Builder
     *
     * @return BuilderEvent
     */
    public function setBuilder(BuilderInterface $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * getBuilder
     *
     * @return BuilderInterface
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * setConfig
     *
     * @param array $config Config
     *
     * @return BuilderEvent
     */
    public function setConfig(array $config)
    {
        $this->config = $config;

        return $this;
    }

    /**
     * getConfig
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

}
