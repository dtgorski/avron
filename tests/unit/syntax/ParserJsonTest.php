<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use Avron\AvronException;
use Avron\AvronTestCase;
use Avron\Config;
use Avron\Factory;
use Avron\Logger;

/**
 * Majority of the JSONParser code is covered by the derived AVDLParser tests.
 *
 * @covers \Avron\AST\ParserJson
 * @uses   \Avron\AST\ByteStreamReader
 * @uses   \Avron\AST\CommentsReadCursor
 * @uses   \Avron\AST\CommentsSaveCursor
 * @uses   \Avron\AST\CommentsSkipCursor
 * @uses   \Avron\AST\FieldDeclarationNode
 * @uses   \Avron\AST\JsonFieldNode
 * @uses   \Avron\AST\Lexer
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\ParserAvdl
 * @uses   \Avron\AST\ParserBase
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Token
 * @uses   \Avron\Avron
 * @uses   \Avron\Factory
 */
class ParserJsonTest extends AvronTestCase
{
    private Factory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        $this->factory = new Factory(
            $this->createMock(Config::class),
            $this->createMock(Logger::class),
        );
    }

    public function testThrowsExceptionWhenInvalidJsonType(): void
    {
        $stream = $this->createStream('{"foo":x}');
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->expectExceptionMessageMatches("/unexpected identifier, expected valid JSON/");
        $parser->parseJson();
    }

    public function testThrowsExceptionWhenInvalidJsonChar(): void
    {
        $stream = $this->createStream("`");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->expectExceptionMessageMatches("/unexpected '`'/");
        $parser->parseJson();
    }
}
