<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\ErrorListNode;
use Avron\Ast\FieldDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class FieldDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof FieldDeclarationNode;
    }

    public function handleLeave(Node $node): void
    {
        /** @var ErrorListNode $node calms static analysis down. */
        parent::handleLeave($node);

        $this->write(";\n");
    }
}
