<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @template-implements \IteratorAggregate<Property>
 */
class Properties implements \IteratorAggregate, \JsonSerializable
{
    /** @param Property[] $properties */
    public static function fromArray(array $properties): Properties
    {
        return new Properties($properties);
    }

    /** @param Property[] $properties */
    private function __construct(private readonly array $properties)
    {
    }

    public function getByName(string $name): ?Property
    {
        foreach ($this->asArray() as $property) {
            if ($name === $property->getName()) {
                return $property;
            }
        }
        return null;
    }

    /** @return Property[] */
    public function asArray(): array
    {
        return $this->properties;
    }

    public function size(): int
    {
        return sizeof($this->asArray());
    }

    public function getIterator(): Traversable
    {
        return new \ArrayIterator($this->asArray());
    }

    public function jsonSerialize(): object
    {
        return (object)$this->asArray();
    }
}
