<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\DeclarationNode;
use Avron\Ast\OnewayStatementNode;
use Avron\Ast\TypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class TypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof TypeNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var TypeNode $node calms static analysis down. */
        parent::handleVisit($node);

        if ($node->parentNode() instanceof DeclarationNode) {
            if (!$node->nodeAt(0) instanceof OnewayStatementNode) {
                $this->write($this->indent());
            }
        } else {
            $this->writePropertiesSingleLine($node->getProperties());
        }
        return true;
    }

    public function handleLeave(Node $node): void
    {
        /** @var TypeNode $node calms static analysis down. */
        parent::handleLeave($node);

        if ($node->nextNode() instanceof TypeNode) {
            $this->write(", ");
        }
    }
}
