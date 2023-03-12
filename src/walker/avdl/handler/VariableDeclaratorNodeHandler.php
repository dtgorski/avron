<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\VariableDeclaratorNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class VariableDeclaratorNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof VariableDeclaratorNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var VariableDeclaratorNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write(" ");
        $this->writePropertiesSingleLine($node->getProperties());
        $this->write($node->getName());

        if ($node->nodeCount()) {
            $this->write(" = ");
        }

        return true;
    }

    public function handleLeave(Node $node): void
    {
        /** @var VariableDeclaratorNode $node calms static analysis down. */
        parent::handleLeave($node);

        if ($node->nextNode()) {
            $this->write(",");
        }
    }
}
