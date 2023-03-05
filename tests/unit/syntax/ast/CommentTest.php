<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\Comment
 * @uses   \Avron\Ast\Token
 */
class CommentTest extends TestCase
{
    public function testFromTokenSingleLineComment(): void
    {
        $str = "/** foo */";
        $com = Comment::fromToken(new Token(Token::COMBLCK, 0, 0, $str));

        $this->assertEquals("foo", $com->getText());
    }

    public function testFromTokenMultilineLineComment(): void
    {
        $str = "/**\n";
        $str .= "foo\n";
        $str .= "bar\n";
        $str .= "*/\n";
        $com = Comment::fromToken(new Token(Token::COMBLCK, 0, 0, $str));

        $this->assertEquals("foo\nbar", $com->getText());
    }
}
