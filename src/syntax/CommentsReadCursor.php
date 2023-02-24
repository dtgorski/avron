<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use Generator;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class CommentsReadCursor implements Cursor
{
    private bool $ahead = false;
    private Token $token;

    public function __construct(
        private readonly Generator $stream,
        private readonly CommentsReadQueue $queue
    ) {
        $this->token = new Token(Token::EOF, 0, 0, "");
    }

    public function peek(): Token
    {
        if (!$this->ahead) {
            $this->token = $this->current();
            $this->ahead = true;
        }
        return $this->token;
    }

    public function next(): Token
    {
        if (!$this->ahead) {
            $this->token = $this->current();
        }
        $this->ahead = false;
        $this->stream->next();

        return $this->token;
    }

    private function current(): Token
    {
        /** @var Token $token calms static analysis down. */
        $token = $this->stream->current();
        return $token;
    }

    public function getCommentQueue(): CommentsReadQueue
    {
        return $this->queue;
    }
}
