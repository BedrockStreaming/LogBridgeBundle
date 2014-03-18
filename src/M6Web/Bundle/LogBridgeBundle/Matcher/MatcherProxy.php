<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

/**
 * MatcherProxy
 */
class MatcherProxy implements MatcherInterface
{
    /**
     * @var BuilderInterface
     */
    private $builder;

    /**
     * @var MatcherInterface
     */
    private static $matcher;

    /**
     * __construct
     *
     * @param BuilderInterface $builder Matcher builder
     */
    public function __construct(BuilderInterface $builder)
    {
        $this->builder = $builder;
        self::$matcher = $builder->getMatcher();
    }

    /**
     * match
     *
     * @param string  $route       Route name
     * @param string  $method      Method name
     * @param integer $status      Http code status
     *
     * @return boolean
     */   
    static public function match($route, $method, $status)
    {
        return self::$matcher->match($route, $method, $status);
    }

    /**
     * getMatcher
     *
     * @return MatcherInterface
     */
    public function getMatcher()
    {
        return self::$matcher;
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

}
