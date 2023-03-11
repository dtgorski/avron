<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template T
 *
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @implements \IteratorAggregate<T>
 */
class ArrayList implements IteratorAggregate
{
    /**
     * @param T[] $elements
     */
    protected function __construct(private readonly array $elements)
    {
    }

    /**
     * @return T[]
     */
    public function asArray(): array
    {
        return $this->elements;
    }

    public function size(): int
    {
        return sizeof($this->elements);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->elements);
    }
}
