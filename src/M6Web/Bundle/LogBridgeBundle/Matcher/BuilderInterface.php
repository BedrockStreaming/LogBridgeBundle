<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\TypeManager as StatusTypeManager;

/**
 * BuilderInterface
 */
interface BuilderInterface
{
    /**
     * __construct
     *
     * @param StatusTypeManager $statusTypeManager Status type manager
     * @param array             $resources         Resources
     * @param string            $environment       Environment name
     */
    public function __construct(StatusTypeManager $statusTypeManager, array $resources, $environment);

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
