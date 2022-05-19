<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\TypeManager as StatusTypeManager;

/**
 * BuilderInterface
 */
interface BuilderInterface
{
    public function __construct(StatusTypeManager $statusTypeManager, array $filters, array $activeFilters);

    public function getMatcher(): MatcherInterface;
}
