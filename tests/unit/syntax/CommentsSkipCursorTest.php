<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\AvronTestCase;

/**
 * @covers \lengo\avron\ast\CommentsSkipCursor
 * @uses   \lengo\avron\ast\CommentsReadQueue
 * @uses   \lengo\avron\ast\ByteStreamReader
 * @uses   \lengo\avron\ast\CommentsReadCursor
 * @uses   \lengo\avron\ast\Lexer
 * @uses   \lengo\avron\ast\Token
 */
class CommentsSkipCursorTest extends AvronTestCase
{
    public function testCursorPeek(): void
    {
        $stream = $this->createStream("/**/ foo . bar : record /**/ //");

        $lexer = new Lexer();
        $reader = new ByteStreamReader($stream);
        $cursor = new CommentsSkipCursor(
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

        $this->assertEquals(Token::EOF, $cursor->peek()->getType());
        $cursor->next();

        $this->closeStream($stream);
    }

    public function testCursorNext(): void
    {
        $stream = $this->createStream("/**/ /**/");

        $lexer = new Lexer();
        $reader = new ByteStreamReader($stream);
        $cursor = new CommentsSkipCursor(
            $lexer->createTokenStream($reader),
            new CommentsReadQueue()
        );

        $this->assertEquals(Token::EOF, $cursor->next()->getType());
    }
}
