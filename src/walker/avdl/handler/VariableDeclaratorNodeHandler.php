<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\VariableDeclaratorNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class VariableDeclaratorNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof VariableDeclaratorNode;
    }

    public function handleVisit(Visitable $visitable): bool
    {
        /** @var VariableDeclaratorNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write(" ");
        $this->writePropertiesSingleLine($visitable->getProperties());
        $this->write($visitable->getName());

        if ($visitable->nodeCount()) {
            $this->write(" = ");
        }

        return true;
    }

    public function handleLeave(Visitable $visitable): void
    {
        /** @var VariableDeclaratorNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        if ($visitable->nextNode()) {
            $this->write(",");
        }
    }
}
