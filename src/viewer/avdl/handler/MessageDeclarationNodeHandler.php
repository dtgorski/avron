<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\MessageDeclarationNode;

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
