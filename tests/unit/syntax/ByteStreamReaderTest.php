<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\AvronTestCase;

/**
 * @covers \lengo\avron\ast\ByteStreamReader
 * @uses   \lengo\avron\ast\CommentsReadQueue
 * @uses   \lengo\avron\ast\CommentsReadCursor
 * @uses   \lengo\avron\ast\Lexer
 * @uses   \lengo\avron\ast\Token
 */
class ByteStreamReaderTest extends AvronTestCase
{
    public function testLineAndColumnAndLoadReportedOnEmptyDocument(): void
    {
        $stream = $this->createStream("");

        $lexer = new Lexer();
        $reader = new ByteStreamReader($stream);
        $cursor = new CommentsReadCursor(
            $lexer->createTokenStream($reader),
            new CommentsReadQueue()
        );

        $this->assertEquals(1, $cursor->peek()->getLine());
        $this->assertEquals(0, $cursor->peek()->getColumn());
        $this->assertTrue($cursor->peek()->is(Token::EOF));

        $this->closeStream($stream);
    }

    public function testLineAndColumnAndLoadReported(): void
    {
        $stream = $this->createStream("");
        fwrite($stream, "foo .\n");        // line #1
        fwrite($stream, "bar :\n");        // line #2
        fwrite($stream, "\n");             // line #3
        fwrite($stream, "record\t/**/\n"); // line #4
        fwrite($stream, " //");            // line #5
        fseek($stream, 0);

        $lexer = new Lexer();
        $reader = new ByteStreamReader($stream);
        $cursor = new CommentsReadCursor(
            $lexer->createTokenStream($reader),
            new CommentsReadQueue()
        );

        $expect = [
            [1, 1], [1, 5], // line #1
            [2, 1], [2, 5], // line #2
            [4, 1], [4, 9], // line #4
            [5, 2]          // line #5
        ];

        $i = 0;
        while (($token = $cursor->next())->isNot(Token::EOF)) {
            $line = $expect[$i][0];
            $col = $expect[$i][1];
            $i++;

            $this->assertEquals($line, $token->getLine(), sprintf("Line fail for %s:", $token->getLoad()));
            $this->assertEquals($col, $token->getColumn(), sprintf("Column fail for %s:", $token->getLoad()));
        }
        fclose($stream);
    }
}
