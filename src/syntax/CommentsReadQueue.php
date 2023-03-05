<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class CommentsReadQueue
{
    /** @var Comment[] $comments */
    private array $comments = [];

    public function enqueue(Comment $comment): void
    {
        $this->comments[] = $comment;
    }

    public function size(): int
    {
        return sizeof($this->comments);
    }

    /** @return Comment[] */
    public function drain(): array
    {
        $comments = $this->comments;
        $this->comments = [];
        return $comments;
    }
}
