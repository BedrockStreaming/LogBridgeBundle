<?php

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\TypeInterface;

/**
 * Class TypeManager
 */
class TypeManager
{
    /** @var array */
    protected $types = [];

    /**
     * Get types
     *
     * @return array
     */
    public function getTypes()
    {
        return $this->types;
    }

    /**
     * Add a type
     *
     * @return $this
     */
    public function addType(TypeInterface $type)
    {
        if (!$this->isType($type)) {
            $typeClass = get_class($type);

            $this->types[$typeClass] = $type;
        }

        return $this;
    }

    /**
     * Remove a type
     *
     * @return $this
     */
    public function removeType(TypeInterface $typeToRemove)
    {
        $namespaceTypeToRemove = get_class($typeToRemove);
        foreach ($this->types as $key => $type) {
            if ($namespaceTypeToRemove === get_class($type)) {
                unset($this->types[$key]);
            }
        }

        return $this;
    }

    /**
     * Check if type pass is already record as type
     *
     * @return bool
     */
    protected function isType(TypeInterface $typeToCheck)
    {
        $namespaceTypeToCheck = get_class($typeToCheck);
        foreach ($this->types as $key => $type) {
            if ($namespaceTypeToCheck === get_class($type)) {
                return true;
            }
        }

        return false;
    }
}
