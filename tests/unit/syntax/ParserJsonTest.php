<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\AvronException;
use Avron\AvronTestCase;
use Avron\Config;
use Avron\Factory;
use Avron\Logger;

/**
 * Majority of the JSONParser code is covered by the derived AVDLParser tests.
 *
 * @covers \Avron\Ast\ParserJson
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\ByteStreamReader
 * @uses   \Avron\Ast\CommentsReadCursor
 * @uses   \Avron\Ast\CommentsSaveCursor
 * @uses   \Avron\Ast\CommentsSkipCursor
 * @uses   \Avron\Ast\FieldDeclarationNode
 * @uses   \Avron\Ast\JsonFieldNode
 * @uses   \Avron\Ast\JsonObjectNode
 * @uses   \Avron\Ast\Lexer
 * @uses   \Avron\Ast\ParserAvdl
 * @uses   \Avron\Ast\ParserBase
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Ast\Token
 * @uses   \Avron\Avron
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
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
