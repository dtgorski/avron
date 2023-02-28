<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @template-implements \IteratorAggregate<Comment>
 */
class Comments implements IteratorAggregate
{
    /** @param Comment[] $comments */
    public static function fromArray(array $comments): Comments
    {
        return new Comments($comments);
    }

    /** @param Comment[] $comments */
    private function __construct(private readonly array $comments)
    {
    }

    public function asArray(): array
    {
        return $this->comments;
    }

    public function size(): int
    {
        return sizeof($this->asArray());
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->asArray());
    }
}
