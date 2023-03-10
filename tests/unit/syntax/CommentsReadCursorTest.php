<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\AvronTestCase;

/**
 * @covers \Avron\Ast\CommentsReadCursor
 * @uses   \Avron\Ast\CommentsReadQueue
 * @uses   \Avron\Ast\ByteStreamReader
 * @uses   \Avron\Ast\Lexer
 * @uses   \Avron\Ast\Token
 */
class CommentsReadCursorTest extends AvronTestCase
{
    public function testCursorProvidesTokens(): void
    {
        $stream = $this->createStream("foo . bar : record /**/ //");

        $lexer = new Lexer();
        $reader = new ByteStreamReader($stream);
        $cursor = new CommentsReadCursor(
            $lexer->createTokenStream($reader),
            new CommentsReadQueue()
        );

        $this->assertEquals(Token::IDENT, $cursor->peek()->getType());
        $this->assertEquals("foo", $cursor->peek()->getLoad());
        $cursor->next();

        $this->assertEquals(Token::DOT, $cursor->peek()->getType());
        $cursor->next();

        $this->assertEquals(Token::IDENT, $cursor->peek()->getType());
        $this->assertEquals("bar", $cursor->peek()->getLoad());
        $cursor->next();

        $this->assertEquals(Token::COLON, $cursor->peek()->getType());
        $cursor->next();

        $this->assertEquals(Token::IDENT, $cursor->peek()->getType());
        $this->assertEquals("record", $cursor->peek()->getLoad());
        $cursor->next();

        $this->assertEquals(Token::COMBLCK, $cursor->peek()->getType());
        $cursor->next();

        $this->assertEquals(Token::COMLINE, $cursor->peek()->getType());
        $cursor->next();

        $this->assertEquals(Token::EOF, $cursor->peek()->getType());
        $cursor->next();

        $this->closeStream($stream);
    }

    public function testCursorProvidesEOF(): void
    {
        $stream = $this->createStream("");

        $lexer = new Lexer();
        $reader = new ByteStreamReader($stream);
        $cursor = new CommentsReadCursor(
            $lexer->createTokenStream($reader),
            new CommentsReadQueue()
        );

        $this->assertEquals(Token::EOF, $cursor->next()->getType());

        $this->closeStream($stream);
    }

    public function testGetCommentQueue(): void
    {
        $stream = $this->createStream("");

        $lexer = new Lexer();
        $reader = new ByteStreamReader($stream);
        $cursor = new CommentsReadCursor(
            $lexer->createTokenStream($reader),
            $comments = new CommentsReadQueue()
        );

        $this->assertSame($comments, $cursor->getCommentQueue());
    }
}
