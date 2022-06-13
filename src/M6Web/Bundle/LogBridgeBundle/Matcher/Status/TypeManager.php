<?php

declare(strict_types=1);

namespace M6Web\Bundle\LogBridgeBundle\Matcher\Status;

use M6Web\Bundle\LogBridgeBundle\Matcher\Status\Type\TypeInterface;

/**
 * Class TypeManager
 */
class TypeManager
{
    /** @var array<class-string<TypeInterface>, TypeInterface> */
    protected array $types = [];

    /**
     * @return array<class-string<TypeInterface>, TypeInterface>
     */
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
            $typeClass = $type::class;

            $this->types[$typeClass] = $type;
        }

        return $this;
    }

    /**
     * Remove a type
     */
    public function removeType(TypeInterface $typeToRemove): self
    {
        $namespaceTypeToRemove = $typeToRemove::class;
        foreach ($this->types as $key => $type) {
            if ($namespaceTypeToRemove === $type::class) {
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
        $namespaceTypeToCheck = $typeToCheck::class;
        foreach ($this->types as $type) {
            if ($namespaceTypeToCheck === $type::class) {
                return true;
            }
        }

        return false;
    }
}
