<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\ProtocolDeclarationNode;

class ProtocolDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof ProtocolDeclarationNode;
    }

    public function handleVisit(Visitable|ProtocolDeclarationNode $visitable): bool
    {
        /** @var ProtocolDeclarationNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write("protocol ", $visitable->getName(), " {\n");

        $this->stepIn();
        return true;
    }

    public function handleLeave(Visitable|ProtocolDeclarationNode $visitable): void
    {
        $this->stepOut();

        /** @var ProtocolDeclarationNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write($this->indent(), "}\n");
    }
}
