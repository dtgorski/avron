<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\AvronException;
use lengo\avron\AvronTestCase;
use lengo\avron\Config;
use lengo\avron\Factory;
use lengo\avron\Logger;

/**
 * Majority of the JSONParser code is covered by the derived AVDLParser tests.
 *
 * @covers \lengo\avron\ast\ParserJson
 * @uses   \lengo\avron\ast\ByteStreamReader
 * @uses   \lengo\avron\ast\CommentsReadCursor
 * @uses   \lengo\avron\ast\CommentsSaveCursor
 * @uses   \lengo\avron\ast\CommentsSkipCursor
 * @uses   \lengo\avron\ast\FieldDeclarationNode
 * @uses   \lengo\avron\ast\JsonFieldNode
 * @uses   \lengo\avron\ast\Lexer
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\ParserAvdl
 * @uses   \lengo\avron\ast\ParserBase
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Token
 * @uses   \lengo\avron\Avron
 * @uses   \lengo\avron\Factory
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
