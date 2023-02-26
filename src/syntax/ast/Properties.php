<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use ArrayIterator;
use IteratorAggregate;
use lengo\avron\cli\Commands;
use lengo\avron\cli\Option;
use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @template-implements \IteratorAggregate<Property>
 */
class Properties implements IteratorAggregate, \JsonSerializable
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

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->properties);
    }

    public function jsonSerialize(): object
    {
        return (object)$this->properties;
    }
}
