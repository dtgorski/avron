<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use lengo\avron\api\SourceFile;
use lengo\avron\api\SourceLoader;
use lengo\avron\api\SourceMap;
use lengo\avron\api\SourceParser;
use lengo\avron\api\Visitor;
use lengo\avron\api\Writer;
use lengo\avron\ast\ByteStreamReader;
use lengo\avron\ast\CommentsReadQueue;
use lengo\avron\ast\CommentsSaveCursor;
use lengo\avron\ast\Lexer;
use lengo\avron\ast\ParserAvdl;
use lengo\avron\avdl\ArrayTypeNodeHandler;
use lengo\avron\avdl\DecimalTypeNodeHandler;
use lengo\avron\avdl\EnumConstantNodeHandler;
use lengo\avron\avdl\EnumDeclarationNodeHandler;
use lengo\avron\avdl\ErrorDeclarationNodeHandler;
use lengo\avron\avdl\ErrorListNodeHandler;
use lengo\avron\avdl\FieldDeclarationNodeHandler;
use lengo\avron\avdl\FixedDeclarationNodeHandler;
use lengo\avron\avdl\FormalParameterNodeHandler;
use lengo\avron\avdl\FormalParametersNodeHandler;
use lengo\avron\avdl\HandlerContext;
use lengo\avron\avdl\ImportStatementNodeHandler;
use lengo\avron\avdl\JsonArrayNodeHandler;
use lengo\avron\avdl\JsonFieldNodeHandler;
use lengo\avron\avdl\JsonObjectNodeHandler;
use lengo\avron\avdl\JsonValueNodeHandler;
use lengo\avron\avdl\LogicalTypeNodeHandler;
use lengo\avron\avdl\MapTypeNodeHandler;
use lengo\avron\avdl\MessageDeclarationNodeHandler;
use lengo\avron\avdl\NullableTypeNodeHandler;
use lengo\avron\avdl\OnewayStatementNodeHandler;
use lengo\avron\avdl\PrimitiveTypeNodeHandler;
use lengo\avron\avdl\ProtocolDeclarationNodeHandler;
use lengo\avron\avdl\RecordDeclarationNodeHandler;
use lengo\avron\avdl\ReferenceTypeNodeHandler;
use lengo\avron\avdl\ResultTypeNodeHandler;
use lengo\avron\avdl\TypeNodeHandler;
use lengo\avron\avdl\UnionTypeNodeHandler;
use lengo\avron\avdl\VariableDeclaratorNodeHandler;
use lengo\avron\core\DeclarationFinalizer;
use lengo\avron\core\ImportsLoader;
use lengo\avron\core\NodeNamespace;
use lengo\avron\core\ProtocolLoader;
use lengo\avron\core\ProtocolParser;
use lengo\avron\core\ProtocolParserVerbose;
use lengo\avron\core\StreamParser;
use lengo\avron\diag\DumpAstVisitor;
use lengo\avron\walker\DelegateHandlerVisitor;

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
