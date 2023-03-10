<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use Avron\Api\SourceFile;
use Avron\Api\SourceMap;
use Avron\AvronException;
use Avron\Factory;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class StreamParser
{
    public function __construct(private readonly Factory $factory)
    {
    }

    /**
     * @param SourceMap $sourceMap
     * @param SourceFile $sourceFile
     * @param resource $stream
     * @throws AvronException
     */
    public function parse(SourceMap $sourceMap, SourceFile $sourceFile, $stream): void
    {
        $parser = $this->factory->createAvdlParser($stream);

        // Create AST from IDL.
        $protocol = $parser->parseProtocol();
        $sourceMap->set($sourceFile, $protocol);

        // Follow and load imports.
        $loader = $this->factory->createImportsLoader($sourceMap, $sourceFile->getDir());
        $protocol->accept($loader);

        // Retrieve namespace information from schema property, if any.
        $namespace = $protocol->getProperties()->getByName("namespace");
        $namespace = NodeNamespace::fromString((string)$namespace?->getValue());

        // Update source file names and namespaces on declaration nodes.
        $finalizer = $this->factory->createDeclarationFinalizer($namespace, $sourceFile);
        $protocol->accept($finalizer);
    }
}
