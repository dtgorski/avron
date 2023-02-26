<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Comments
{
    public static function fromArray(array $comments): Comments
    {
        return new Comments($comments);
    }

    /** @param Comment[] $comments */
    private function __construct(private readonly array $comments)
    {
    }

    public function size(): int
    {
        return sizeof($this->comments);
    }

    public function asArray(): array
    {
        return $this->comments;
    }
}
