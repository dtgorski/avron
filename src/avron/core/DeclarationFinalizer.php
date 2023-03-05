<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use Avron\Api\SourceFile;
use Avron\Api\Visitable;
use Avron\Api\Visitor;
use Avron\Ast\DeclarationNode;
use Avron\AvronException;

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
