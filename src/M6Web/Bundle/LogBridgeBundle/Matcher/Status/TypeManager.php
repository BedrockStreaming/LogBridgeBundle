<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\TypeInterface;

/**
 * Class TypeManager
 */
class TypeManager
{
    protected array $types = [];

    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * Add a type
     */
    public function addType(TypeInterface $type): self
    {
        if (!$this->isType($type)) {
            $typeClass = get_class($type);

            $this->types[$typeClass] = $type;
        }

        return $this;
    }

    /**
     * Remove a type
     */
    public function removeType(TypeInterface $typeToRemove): self
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
     */
    protected function isType(TypeInterface $typeToCheck): bool
    {
        $namespaceTypeToCheck = get_class($typeToCheck);
        foreach ($this->types as $type) {
            if ($namespaceTypeToCheck === get_class($type)) {
                return true;
            }
        }

        return false;
    }
}
