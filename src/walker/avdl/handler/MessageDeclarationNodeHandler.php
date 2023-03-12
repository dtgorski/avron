<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\MessageDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class MessageDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof MessageDeclarationNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var MessageDeclarationNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write($this->indent());

        return true;
    }

    public function handleLeave(Node $node): void
    {
        /** @var MessageDeclarationNode $node calms static analysis down. */
        parent::handleLeave($node);

        $this->write(";\n");
    }
}
