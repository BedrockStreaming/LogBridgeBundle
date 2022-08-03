<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\TypeManager as StatusTypeManager;

/**
 * BuilderInterface
 */
interface BuilderInterface
{
    /**
     * @param array<string, array{
     *     routes?: string[],
     *     method?: string[],
     *     status?: int[],
     *     level?: string,
     *     options?: array{post_parameters?: bool, response_body?: bool}
     * }> $filters
     * @param string[] $activeFilters
     */
    public function __construct(StatusTypeManager $statusTypeManager, array $filters, array $activeFilters);

    public function getMatcher(): MatcherInterface;
}
