<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\AvronException;
use Avron\AvronTestCase;
use Avron\BufferedWriter;
use Avron\Config;
use Avron\Diag\DumpAstVisitor;
use Avron\Factory;
use Avron\Logger;

/**
 * @covers \Avron\Ast\ParserBase
 * @covers \Avron\Ast\ParserAvdl
 * @covers \Avron\Ast\ParserJson
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\ByteStreamReader
 * @uses   \Avron\Ast\Comment
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\CommentsReadCursor
 * @uses   \Avron\Ast\CommentsReadQueue
 * @uses   \Avron\Ast\CommentsSaveCursor
 * @uses   \Avron\Ast\DecimalTypeNode
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\EnumConstantNode
 * @uses   \Avron\Ast\EnumDeclarationNode
 * @uses   \Avron\Ast\ErrorDeclarationNode
 * @uses   \Avron\Ast\ErrorListNode
 * @uses   \Avron\Ast\ErrorType
 * @uses   \Avron\Ast\FieldDeclarationNode
 * @uses   \Avron\Ast\FixedDeclarationNode
 * @uses   \Avron\Ast\ImportStatementNode
 * @uses   \Avron\Ast\ImportType
 * @uses   \Avron\Ast\JsonArrayNode
 * @uses   \Avron\Ast\JsonFieldNode
 * @uses   \Avron\Ast\JsonObjectNode
 * @uses   \Avron\Ast\JsonValueNode
 * @uses   \Avron\Ast\Lexer
 * @uses   \Avron\Ast\LogicalType
 * @uses   \Avron\Ast\LogicalTypeNode
 * @uses   \Avron\Ast\MessageDeclarationNode
 * @uses   \Avron\Ast\NamedType
 * @uses   \Avron\Ast\PrimitiveType
 * @uses   \Avron\Ast\PrimitiveTypeNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Ast\Property
 * @uses   \Avron\Ast\ProtocolDeclarationNode
 * @uses   \Avron\Ast\RecordDeclarationNode
 * @uses   \Avron\Ast\ReferenceTypeNode
 * @uses   \Avron\Ast\ResultTypeNode
 * @uses   \Avron\Ast\Token
 * @uses   \Avron\Ast\TypeNode
 * @uses   \Avron\Ast\VariableDeclaratorNode
 * @uses   \Avron\Avron
 * @uses   \Avron\AvronException
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Diag\DumpAstVisitor
 * @uses   \Avron\Factory
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
