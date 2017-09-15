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
     * @param string            $environment       Environment name
     * @param array             $filters           Filters
     * @param array             $activeFilters     Active Filters
     */
    public function __construct(StatusTypeManager $statusTypeManager, array $filters, array $activeFilters, $environment);

    /**
     * getMatcher
     *
     * @return MatcherInterface
     */
    public function getMatcher();

}
