<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\FormalParametersNode;
use Avron\Ast\MessageDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class FormalParametersNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof FormalParametersNode;
    }

    public function handleVisit(Visitable $visitable): bool
    {
        /** @var FormalParametersNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        /** @var MessageDeclarationNode $message calms static analysis down. */
        $message = $visitable->parentNode();

        $this->write(" ", $message->getName(), "(");

        return true;
    }

    public function handleLeave(Visitable $visitable): void
    {
        /** @var FormalParametersNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write(")");
    }
}
