<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\DeclarationNode;
use Avron\Ast\OnewayStatementNode;
use Avron\Ast\TypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class TypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof TypeNode;
    }

    public function handleVisit(Visitable|TypeNode $visitable): bool
    {
        /** @var TypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->getParent() instanceof DeclarationNode) {
            if (!$visitable->getChildNodeAt(0) instanceof OnewayStatementNode) {
                $this->write($this->indent());
            }
        } else {
            $this->writePropertiesSingleLine($visitable->getProperties());
        }
        return true;
    }

    public function handleLeave(Visitable|TypeNode $visitable): void
    {
        /** @var TypeNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        if ($visitable->getNextSibling() instanceof TypeNode) {
            $this->write(", ");
        }
    }
}
