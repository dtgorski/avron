<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\ProtocolDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ProtocolDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof ProtocolDeclarationNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var ProtocolDeclarationNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write("protocol ", $node->getName(), " {\n");

        $this->stepIn();
        return true;
    }

    public function handleLeave(Node $node): void
    {
        $this->stepOut();

        /** @var ProtocolDeclarationNode $node calms static analysis down. */
        parent::handleLeave($node);

        $this->write($this->indent(), "}\n");
    }
}
