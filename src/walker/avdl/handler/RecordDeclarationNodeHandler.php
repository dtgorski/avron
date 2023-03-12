<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\RecordDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class RecordDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof RecordDeclarationNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var RecordDeclarationNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write($this->indent(), "record ", $node->getName(), " {\n");

        $this->stepIn();
        return true;
    }

    public function handleLeave(Node $node): void
    {
        $this->stepOut();

        /** @var RecordDeclarationNode $node calms static analysis down. */
        parent::handleLeave($node);

        $this->write($this->indent(), "}\n");
    }
}
