<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceFile;
use lengo\avron\api\Visitable;
use lengo\avron\api\Visitor;
use lengo\avron\ast\DeclarationNode;
use lengo\avron\AvroException;

/** Sets filename and namespace on declaration nodes. */
class DeclarationFinalizer implements Visitor
{
    public function __construct(
        private readonly NodeNamespace $namespace,
        private readonly SourceFile $sourceFile
    ) {
    }

    /** @throws AvroException */
    public function visit(Visitable $node): bool
    {
        if (!$node instanceof DeclarationNode) {
            return true;
        }

        // When schema property "namespace" is explicitly set.
        if ($namespace = $node->getProperties()->getByName("namespace")) {
            $node->setNamespace(NodeNamespace::fromString((string)$namespace->getValue()));
        } else {
            $node->setNamespace($this->namespace);
        }

        // Set source file.
        $node->setSourceFile($this->sourceFile);

        return true;
    }

    public function leave(Visitable $node): void
    {
    }
}