<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class CommentsSaveCursor extends CommentsReadCursor
{
    public function peek(): Token
    {
        while ($token = parent::peek()) {
            if ($token->is(Token::COMLINE)) { // Line comments skipped
                parent::next();
                continue;
            }
            if ($token->is(Token::COMBLCK)) {
                $this->getCommentQueue()->enqueue(Comment::fromToken($token));
                parent::next();
                continue;
            }
            break;
        }
        return parent::peek();
    }

    public function next(): Token
    {
        while ($token = parent::peek()) {
            if ($token->is(Token::COMLINE)) { // Line comments skipped
                parent::next();
                continue;
            }
            if ($token->is(Token::COMBLCK)) {
                $this->getCommentQueue()->enqueue(Comment::fromToken($token));
                parent::next();
                continue;
            }
            break;
        }
        return parent::next();
    }
}
