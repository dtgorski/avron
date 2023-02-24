<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @template-implements \IteratorAggregate<Property>
 */
class Properties implements IteratorAggregate, \JsonSerializable
{
    /** @var Property[] */
    private array $props = [];

    public function add(Property $property): Properties
    {
        $this->props[] = $property;
        return $this;
    }

    public function getByName(string $name): ?Property
    {
        foreach ($this->props as $prop) {
            if ($name === $prop->getName()) {
                return $prop;
            }
        }
        return null;
    }

    public function size(): int
    {
        return sizeof($this->props);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->props);
    }

    public function jsonSerialize(): object
    {
        return (object)$this->props;
    }
}
