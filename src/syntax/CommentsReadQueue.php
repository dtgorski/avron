<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

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
