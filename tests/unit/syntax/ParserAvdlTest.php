<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use Avron\AvronException;
use Avron\AvronTestCase;
use Avron\BufferedWriter;
use Avron\Config;
use Avron\Diag\DumpAstVisitor;
use Avron\Factory;
use Avron\Logger;

/**
 * @covers \Avron\AST\ParserBase
 * @covers \Avron\AST\ParserAvdl
 * @covers \Avron\AST\ParserJson
 * @uses   \Avron\AST\ByteStreamReader
 * @uses   \Avron\AST\Comment
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\CommentsReadCursor
 * @uses   \Avron\AST\CommentsReadQueue
 * @uses   \Avron\AST\CommentsSaveCursor
 * @uses   \Avron\AST\DecimalTypeNode
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\EnumConstantNode
 * @uses   \Avron\AST\EnumDeclarationNode
 * @uses   \Avron\AST\ErrorDeclarationNode
 * @uses   \Avron\AST\ErrorListNode
 * @uses   \Avron\AST\ErrorType
 * @uses   \Avron\AST\FieldDeclarationNode
 * @uses   \Avron\AST\FixedDeclarationNode
 * @uses   \Avron\AST\ImportStatementNode
 * @uses   \Avron\AST\ImportType
 * @uses   \Avron\AST\JsonArrayNode
 * @uses   \Avron\AST\JsonFieldNode
 * @uses   \Avron\AST\JsonObjectNode
 * @uses   \Avron\AST\JsonValueNode
 * @uses   \Avron\AST\Lexer
 * @uses   \Avron\AST\LogicalTypeNode
 * @uses   \Avron\AST\LogicalType
 * @uses   \Avron\AST\MessageDeclarationNode
 * @uses   \Avron\AST\NamedType
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\PrimitiveTypeNode
 * @uses   \Avron\AST\PrimitiveType
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Property
 * @uses   \Avron\AST\ProtocolDeclarationNode
 * @uses   \Avron\AST\RecordDeclarationNode
 * @uses   \Avron\AST\ReferenceTypeNode
 * @uses   \Avron\AST\ResultTypeNode
 * @uses   \Avron\AST\Token
 * @uses   \Avron\AST\TypeNode
 * @uses   \Avron\AST\VariableDeclaratorNode
 * @uses   \Avron\Avron
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Factory
 * @uses   \Avron\Diag\DumpAstVisitor
 * @uses   \Avron\AvronException
 */
class ParserAvdlTest extends AvronTestCase
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

    /** @dataProvider provideStencilFiles */
    public function testSyntax(string $filename): void
    {
        [$have, $want] = $this->readStencil($filename);

        $stream = fopen("php://memory", "rw");
        fwrite($stream, $have);
        fseek($stream, 0);

        try {
            $parser = $this->factory->createAvdlParser($stream);
            $writer = new BufferedWriter();
            $dumper = new DumpAstVisitor($writer);
            $parser->parseProtocol()->accept($dumper);
            $got = $writer->getBuffer();

        } catch (AvronException $e) {
            $got = $e->getError();
        }

        fclose($stream);

        $this->assertEquals($want, $got, sprintf("in %s", $filename));
    }

    public function readStencil(string $filename): array
    {
        $stencil = file_get_contents($filename);
        $blocks = preg_split("/---\n/", $stencil, 3);
        return [$blocks[1], $blocks[2]];
    }

    public function provideStencilFiles(): array
    {
        $filenames = glob(sprintf("%s/../../data/avdl-test-*\.stencil", __DIR__));
        return array_map(fn($v): array => [$v], $filenames);
    }

    public function testExpectEOF(): void
    {
        $stream = $this->createStream("");
        $parser = $this->factory->createAvdlParser($stream);

        $this->assertFalse($parser->expect(Token::TICK));
    }

    public function testThrowsExceptionWhenConsumeEOF(): void
    {
        $stream = $this->createStream("");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->assertFalse($parser->consume(Token::TICK));
    }

    public function testThrowsExceptionWhenConsumeWithHintEOF(): void
    {
        $stream = $this->createStream("");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->assertFalse($parser->consumeWithHint(Token::TICK, ""));
    }

    public function testThrowsExceptionWhenConsumeWrongTokenType(): void
    {
        $stream = $this->createStream("foo");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->assertFalse($parser->consume(Token::TICK));
    }

    public function testThrowsExceptionWhenConsumeWithHintWrongTokenType(): void
    {
        $stream = $this->createStream("foo");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->assertFalse($parser->consumeWithHint(Token::TICK, ""));
    }

    public function testThrowsExceptionWhenConsumeUnacceptedTokenLoad(): void
    {
        $stream = $this->createStream("foo");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->assertFalse($parser->consume(Token::IDENT, "bar"));
    }

    public function testThrowsExceptionWhenConsumeWithHintUnacceptedTokenLoad(): void
    {
        $stream = $this->createStream("foo");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->assertFalse($parser->consumeWithHint(Token::IDENT, "", "bar"));
    }

    public function testThrowsExceptionWhenInvalidDecimalTypePrecision(): void
    {
        $stream = $this->createStream("protocol x { decimal(-1, 0) foo(); } ");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->expectExceptionMessageMatches("/unexpected negative decimal type precision/");
        $parser->parseProtocol();
    }

    public function testThrowsExceptionWhenInvalidDecimalTypeScale(): void
    {
        $stream = $this->createStream("protocol x { decimal(0, -1) foo(); } ");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvronException::class);
        $this->expectExceptionMessageMatches("/unexpected invalid decimal type scale/");
        $parser->parseProtocol();
    }
}
