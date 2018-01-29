<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type;

/**
 * Abstract class AbstractType
 */
abstract class AbstractType implements TypeInterface
{
    /**
     * @var string
     */
    protected $pattern;

    /**
     * Match with config status
     *
     * @param string $config
     *
     * @return bool
     */
    public function match($config)
    {
        return preg_match($this->getPattern(), $config);
    }

    /**
     * Get status list
     *
     * @param string $config
     *
     * @throws \Exception transform method must be return an array
     *
     * @return array
     */
    final public function getStatus($config)
    {
        if ($this->isExclude($config)) {
            $config = substr($config, 1);
        }

        $status = $this->transform($config);

        if (!is_array($status)) {
            throw new \Exception(
                sprintf('"transform" method must be return an array in class "%s"', get_class($this)),
                500
            );
        }

        return $status;
    }

    /**
     * Match with config status
     *
     * @param string $config
     *
     * @return bool
     */
    final public function isExclude($config)
    {
        if (strpos($config, '!') !== false) {
            return true;
        }

        return false;
    }

    /**
     * getPattern
     *
     * @return string
     */
    abstract protected function getPattern();

    /**
     * Transform config to status list
     *
     * @param string $config
     *
     * @return array
     */
    abstract protected function transform($config);
}
