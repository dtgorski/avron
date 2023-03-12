<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\FormalParametersNode;
use Avron\Ast\MessageDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class FormalParametersNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof FormalParametersNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var FormalParametersNode $node calms static analysis down. */
        parent::handleVisit($node);

        /** @var MessageDeclarationNode $message calms static analysis down. */
        $message = $node->parentNode();

        $this->write(" ", $message->getName(), "(");

        return true;
    }

    public function handleLeave(Node $node): void
    {
        /** @var FormalParametersNode $node calms static analysis down. */
        parent::handleLeave($node);

        $this->write(")");
    }
}
