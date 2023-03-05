<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron;

use Avron\Api\SourceFile;
use Avron\Api\SourceLoader;
use Avron\Api\SourceMap;
use Avron\Api\SourceParser;
use Avron\Api\Visitor;
use Avron\Api\Writer;
use Avron\Ast\ByteStreamReader;
use Avron\Ast\CommentsReadQueue;
use Avron\Ast\CommentsSaveCursor;
use Avron\Ast\Lexer;
use Avron\Ast\ParserAvdl;
use Avron\Idl\ArrayTypeNodeHandler;
use Avron\Idl\DecimalTypeNodeHandler;
use Avron\Idl\EnumConstantNodeHandler;
use Avron\Idl\EnumDeclarationNodeHandler;
use Avron\Idl\ErrorDeclarationNodeHandler;
use Avron\Idl\ErrorListNodeHandler;
use Avron\Idl\FieldDeclarationNodeHandler;
use Avron\Idl\FixedDeclarationNodeHandler;
use Avron\Idl\FormalParameterNodeHandler;
use Avron\Idl\FormalParametersNodeHandler;
use Avron\Idl\HandlerContext;
use Avron\Idl\ImportStatementNodeHandler;
use Avron\Idl\JsonArrayNodeHandler;
use Avron\Idl\JsonFieldNodeHandler;
use Avron\Idl\JsonObjectNodeHandler;
use Avron\Idl\JsonValueNodeHandler;
use Avron\Idl\LogicalTypeNodeHandler;
use Avron\Idl\MapTypeNodeHandler;
use Avron\Idl\MessageDeclarationNodeHandler;
use Avron\Idl\NullableTypeNodeHandler;
use Avron\Idl\OnewayStatementNodeHandler;
use Avron\Idl\PrimitiveTypeNodeHandler;
use Avron\Idl\ProtocolDeclarationNodeHandler;
use Avron\Idl\RecordDeclarationNodeHandler;
use Avron\Idl\ReferenceTypeNodeHandler;
use Avron\Idl\ResultTypeNodeHandler;
use Avron\Idl\TypeNodeHandler;
use Avron\Idl\UnionTypeNodeHandler;
use Avron\Idl\VariableDeclaratorNodeHandler;
use Avron\Core\DeclarationFinalizer;
use Avron\Core\ImportsLoader;
use Avron\Core\NodeNamespace;
use Avron\Core\ProtocolLoader;
use Avron\Core\ProtocolParser;
use Avron\Core\ProtocolParserVerbose;
use Avron\Core\StreamParser;
use Avron\Diag\DumpAstVisitor;
use Avron\Walker\DelegateHandlerVisitor;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Factory
{
    public function __construct(
        private readonly Config $config,
        private readonly Logger $logger,
    ) {
    }

    public function getConfig(): Config
    {
        return $this->config;
    }

    /** @param resource $stream */
    public function createAvdlParser($stream): ParserAvdl
    {
        $lexer = new Lexer();
        $reader = new ByteStreamReader($stream);
        $cursor = new CommentsSaveCursor($lexer->createTokenStream($reader), new CommentsReadQueue());

        return new ParserAvdl($cursor);
    }

    public function createProtocolLoader(): SourceLoader
    {
        return new ProtocolLoader($this->createProtocolParser());
    }

    public function createImportsLoader(SourceMap $map, string $filename): ImportsLoader
    {
        return new ImportsLoader($this->createProtocolParser(), $map, $filename);
    }

    public function createProtocolParser(): SourceParser
    {
        $parser = new ProtocolParser($this->createStreamParser());

        return $this->config->verbosityLevel() > 0
            ? new ProtocolParserVerbose($parser, $this->logger)
            : $parser;
    }

    public function createStreamParser(): StreamParser
    {
        return new StreamParser($this);
    }

    public function createDeclarationFinalizer(NodeNamespace $namespace, SourceFile $sourceFile): DeclarationFinalizer
    {
        return new DeclarationFinalizer($namespace, $sourceFile);
    }

    public function createAvdlPrinter(Writer $writer = new StandardWriter(STDOUT)): Visitor
    {
        $ctx = new HandlerContext($writer);

        return new DelegateHandlerVisitor([
            new ArrayTypeNodeHandler($ctx),
            new DecimalTypeNodeHandler($ctx),
            new EnumConstantNodeHandler($ctx),
            new EnumDeclarationNodeHandler($ctx),
            new ErrorDeclarationNodeHandler($ctx),
            new ErrorListNodeHandler($ctx),
            new FieldDeclarationNodeHandler($ctx),
            new FixedDeclarationNodeHandler($ctx),
            new FormalParameterNodeHandler($ctx),
            new FormalParametersNodeHandler($ctx),
            new ImportStatementNodeHandler($ctx),
            new JsonArrayNodeHandler($ctx),
            new JsonFieldNodeHandler($ctx),
            new JsonObjectNodeHandler($ctx),
            new JsonValueNodeHandler($ctx),
            new LogicalTypeNodeHandler($ctx),
            new MapTypeNodeHandler($ctx),
            new MessageDeclarationNodeHandler($ctx),
            new NullableTypeNodeHandler($ctx),
            new OnewayStatementNodeHandler($ctx),
            new PrimitiveTypeNodeHandler($ctx),
            new ProtocolDeclarationNodeHandler($ctx),
            new RecordDeclarationNodeHandler($ctx),
            new ReferenceTypeNodeHandler($ctx),
            new ResultTypeNodeHandler($ctx),
            new TypeNodeHandler($ctx),
            new UnionTypeNodeHandler($ctx),
            new VariableDeclaratorNodeHandler($ctx),
        ]);
    }

    public function createTreeDumper(Writer $writer = new StandardWriter(STDOUT)): Visitor
    {
        return new DumpAstVisitor($writer);
    }
}
