<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\DeclarationNode;
use lengo\avron\ast\OnewayStatementNode;
use lengo\avron\ast\TypeNode;

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
