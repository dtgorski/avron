<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceFile;
use lengo\avron\api\Visitable;
use lengo\avron\api\Visitor;
use lengo\avron\ast\DeclarationNode;
use lengo\avron\AvronException;

/**
 * Sets filename and namespace on declaration nodes.
 *
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class DeclarationFinalizer implements Visitor
{
    public function __construct(
        private readonly NodeNamespace $namespace,
        private readonly SourceFile $sourceFile
    ) {
    }

    /** @throws AvronException */
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
