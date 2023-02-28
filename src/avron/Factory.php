<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron;

use Avron\API\SourceFile;
use Avron\API\SourceLoader;
use Avron\API\SourceMap;
use Avron\API\SourceParser;
use Avron\API\Visitor;
use Avron\API\Writer;
use Avron\AST\ByteStreamReader;
use Avron\AST\CommentsReadQueue;
use Avron\AST\CommentsSaveCursor;
use Avron\AST\Lexer;
use Avron\AST\ParserAvdl;
use Avron\AVDL\ArrayTypeNodeHandler;
use Avron\AVDL\DecimalTypeNodeHandler;
use Avron\AVDL\EnumConstantNodeHandler;
use Avron\AVDL\EnumDeclarationNodeHandler;
use Avron\AVDL\ErrorDeclarationNodeHandler;
use Avron\AVDL\ErrorListNodeHandler;
use Avron\AVDL\FieldDeclarationNodeHandler;
use Avron\AVDL\FixedDeclarationNodeHandler;
use Avron\AVDL\FormalParameterNodeHandler;
use Avron\AVDL\FormalParametersNodeHandler;
use Avron\AVDL\HandlerContext;
use Avron\AVDL\ImportStatementNodeHandler;
use Avron\AVDL\JsonArrayNodeHandler;
use Avron\AVDL\JsonFieldNodeHandler;
use Avron\AVDL\JsonObjectNodeHandler;
use Avron\AVDL\JsonValueNodeHandler;
use Avron\AVDL\LogicalTypeNodeHandler;
use Avron\AVDL\MapTypeNodeHandler;
use Avron\AVDL\MessageDeclarationNodeHandler;
use Avron\AVDL\NullableTypeNodeHandler;
use Avron\AVDL\OnewayStatementNodeHandler;
use Avron\AVDL\PrimitiveTypeNodeHandler;
use Avron\AVDL\ProtocolDeclarationNodeHandler;
use Avron\AVDL\RecordDeclarationNodeHandler;
use Avron\AVDL\ReferenceTypeNodeHandler;
use Avron\AVDL\ResultTypeNodeHandler;
use Avron\AVDL\TypeNodeHandler;
use Avron\AVDL\UnionTypeNodeHandler;
use Avron\AVDL\VariableDeclaratorNodeHandler;
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
