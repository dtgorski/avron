<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\AvroException;
use lengo\avron\AvronTestCase;
use lengo\avron\BufferedWriter;
use lengo\avron\Config;
use lengo\avron\diag\DumpAstVisitor;
use lengo\avron\Factory;
use lengo\avron\Logger;

/**
 * @covers \lengo\avron\ast\ParserBase
 * @covers \lengo\avron\ast\ParserAvdl
 * @covers \lengo\avron\ast\ParserJson
 * @uses   \lengo\avron\ast\ByteStreamReader
 * @uses   \lengo\avron\ast\Comment
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\CommentsReadCursor
 * @uses   \lengo\avron\ast\CommentsReadQueue
 * @uses   \lengo\avron\ast\CommentsSaveCursor
 * @uses   \lengo\avron\ast\DecimalTypeNode
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\EnumConstantNode
 * @uses   \lengo\avron\ast\EnumDeclarationNode
 * @uses   \lengo\avron\ast\ErrorDeclarationNode
 * @uses   \lengo\avron\ast\ErrorListNode
 * @uses   \lengo\avron\ast\ErrorTypes
 * @uses   \lengo\avron\ast\FieldDeclarationNode
 * @uses   \lengo\avron\ast\FixedDeclarationNode
 * @uses   \lengo\avron\ast\ImportStatementNode
 * @uses   \lengo\avron\ast\ImportTypes
 * @uses   \lengo\avron\ast\JsonArrayNode
 * @uses   \lengo\avron\ast\JsonFieldNode
 * @uses   \lengo\avron\ast\JsonObjectNode
 * @uses   \lengo\avron\ast\JsonValueNode
 * @uses   \lengo\avron\ast\Lexer
 * @uses   \lengo\avron\ast\LogicalTypeNode
 * @uses   \lengo\avron\ast\LogicalTypes
 * @uses   \lengo\avron\ast\MessageDeclarationNode
 * @uses   \lengo\avron\ast\NamedTypes
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\PrimitiveTypeNode
 * @uses   \lengo\avron\ast\PrimitiveTypes
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Property
 * @uses   \lengo\avron\ast\ProtocolDeclarationNode
 * @uses   \lengo\avron\ast\RecordDeclarationNode
 * @uses   \lengo\avron\ast\ReferenceTypeNode
 * @uses   \lengo\avron\ast\ResultTypeNode
 * @uses   \lengo\avron\ast\Token
 * @uses   \lengo\avron\ast\TypeNode
 * @uses   \lengo\avron\ast\VariableDeclaratorNode
 * @uses   \lengo\avron\Avron
 * @uses   \lengo\avron\BufferedWriter
 * @uses   \lengo\avron\Factory
 * @uses   \lengo\avron\diag\DumpAstVisitor
 * @uses   \lengo\avron\AvroException
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

        } catch (AvroException $e) {
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

        $this->expectException(AvroException::class);
        $this->assertFalse($parser->consume(Token::TICK));
    }

    public function testThrowsExceptionWhenConsumeWithHintEOF(): void
    {
        $stream = $this->createStream("");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvroException::class);
        $this->assertFalse($parser->consumeWithHint(Token::TICK, ""));
    }

    public function testThrowsExceptionWhenConsumeWrongTokenType(): void
    {
        $stream = $this->createStream("foo");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvroException::class);
        $this->assertFalse($parser->consume(Token::TICK));
    }

    public function testThrowsExceptionWhenConsumeWithHintWrongTokenType(): void
    {
        $stream = $this->createStream("foo");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvroException::class);
        $this->assertFalse($parser->consumeWithHint(Token::TICK, ""));
    }

    public function testThrowsExceptionWhenConsumeUnacceptedTokenLoad(): void
    {
        $stream = $this->createStream("foo");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvroException::class);
        $this->assertFalse($parser->consume(Token::IDENT, "bar"));
    }

    public function testThrowsExceptionWhenConsumeWithHintUnacceptedTokenLoad(): void
    {
        $stream = $this->createStream("foo");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvroException::class);
        $this->assertFalse($parser->consumeWithHint(Token::IDENT, "", "bar"));
    }

    public function testThrowsExceptionWhenInvalidDecimalTypePrecision(): void
    {
        $stream = $this->createStream("protocol x { decimal(-1, 0) foo(); } ");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvroException::class);
        $this->expectExceptionMessageMatches("/unexpected negative decimal type precision/");
        $parser->parseProtocol();
    }

    public function testThrowsExceptionWhenInvalidDecimalTypeScale(): void
    {
        $stream = $this->createStream("protocol x { decimal(0, -1) foo(); } ");
        $parser = $this->factory->createAvdlParser($stream);

        $this->expectException(AvroException::class);
        $this->expectExceptionMessageMatches("/unexpected invalid decimal type scale/");
        $parser->parseProtocol();
    }
}
