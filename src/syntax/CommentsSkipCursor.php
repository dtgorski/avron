<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/** @internal This class is not part of the official API. */
class CommentsSkipCursor extends CommentsReadCursor
{
    public function peek(): Token
    {
        while ($this->isComment(parent::peek())) {
            parent::next();
        }
        return parent::peek();
    }

    public function next(): Token
    {
        while ($this->isComment(parent::peek())) {
            parent::next();
        }
        return parent::next();
    }

    private function isComment(Token $token): bool
    {
        return $token->is(Token::COMLINE)
            || $token->is(Token::COMBLCK);
    }
}
