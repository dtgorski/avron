<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\Comment
 * @uses   \lengo\avron\ast\Token
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
