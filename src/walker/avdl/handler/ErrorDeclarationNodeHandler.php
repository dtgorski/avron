<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\ErrorDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ErrorDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof ErrorDeclarationNode;
    }

    public function handleVisit(Visitable|ErrorDeclarationNode $visitable): bool
    {
        /** @var ErrorDeclarationNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write($this->indent(), "error ", $visitable->getName(), " {\n");
        $this->stepIn();

        return true;
    }

    public function handleLeave(Visitable|ErrorDeclarationNode $visitable): void
    {
        $this->stepOut();

        /** @var ErrorDeclarationNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write($this->indent(), "}\n");
    }
}
