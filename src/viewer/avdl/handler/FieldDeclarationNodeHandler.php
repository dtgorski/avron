<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\API\Visitable;
use Avron\AST\ErrorListNode;
use Avron\AST\FieldDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class FieldDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof FieldDeclarationNode;
    }

    public function handleLeave(Visitable|FieldDeclarationNode $visitable): void
    {
        /** @var ErrorListNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write(";\n");
    }
}
