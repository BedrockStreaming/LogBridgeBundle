<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

/**
 * BuilderInterface
 */
interface BuilderInterface
{
    /**
     * __construct
     *
     * @param array $resources Resources
     */
    public function __construct(array $resources);

    /**
     * getMatcher
     *
     * @return MatcherInterface
     */
    public function getMatcher();

    /**
     * setResources
     *
     * @param array $resources Resources
     *
     * @return Builder
     */
    public function setResources(array $resources);

    /**
     * getResources
     *
     * @return array
     */
    public function getResources();

    /**
     * addResource
     *
     * @param string $resource Resource
     *
     * @return Builder
     */
    public function addResource($resource);

}
