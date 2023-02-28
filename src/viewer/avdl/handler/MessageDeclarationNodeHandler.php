<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\API\Visitable;
use Avron\AST\MessageDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class MessageDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof MessageDeclarationNode;
    }

    public function handleVisit(Visitable|MessageDeclarationNode $visitable): bool
    {
        /** @var MessageDeclarationNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write($this->indent());

        return true;
    }

    public function handleLeave(Visitable|MessageDeclarationNode $visitable): void
    {
        /** @var MessageDeclarationNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write(";\n");
    }
}
