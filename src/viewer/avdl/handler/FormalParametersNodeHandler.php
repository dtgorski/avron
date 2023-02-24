<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\FormalParametersNode;
use lengo\avron\ast\MessageDeclarationNode;

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

    public function handleVisit(Visitable|FormalParametersNode $visitable): bool
    {
        /** @var FormalParametersNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        /** @var MessageDeclarationNode $message calms static analysis down. */
        $message = $visitable->getParent();

        $this->write(" ", $message->getName(), "(");

        return true;
    }

    public function handleLeave(Visitable|FormalParametersNode $visitable): void
    {
        /** @var FormalParametersNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write(")");
    }
}
