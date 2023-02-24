<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

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
    public function __construct(private array $comments = [])
    {
    }

    public function add(Comment $comment): Comments
    {
        $this->comments[] = $comment;
        return $this;
    }

    public function size(): int
    {
        return sizeof($this->comments);
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->comments);
    }
}
