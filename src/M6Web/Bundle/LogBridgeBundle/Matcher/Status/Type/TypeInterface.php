<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Interface TypeInterface
 */
interface TypeInterface
{
    /**
     * Match with config status
     *
     * @param string $config
     *
     * @return bool
     */
    public function match($config);

    /**
     * Get status list
     *
     * @param string $config
     *
     * @return array
     */
    public function getStatus($config);
}
