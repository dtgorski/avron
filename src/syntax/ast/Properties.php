<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Properties
{
    /** @param Property[] $properties */
    public static function fromArray(array $properties): Properties
    {
        return new Properties($properties);
    }

    /** @param Property[] $properties */
    private function __construct(private readonly array $properties)
    {
        // TODO: check uniqueness of short & long options
    }

    public function getByName(string $name): ?Property
    {
        foreach ($this->properties as $property) {
            if ($name === $property->getName()) {
                return $property;
            }
        }
        return null;
    }

    public function size(): int
    {
        return sizeof($this->properties);
    }

    public function asArray(): array
    {
        return $this->properties;
    }
}
