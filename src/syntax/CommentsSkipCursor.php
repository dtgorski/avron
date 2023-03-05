<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
