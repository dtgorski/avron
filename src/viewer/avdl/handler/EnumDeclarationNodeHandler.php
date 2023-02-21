<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\EnumDeclarationNode;

/** @internal This class is not part of the official API. */
class EnumDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof EnumDeclarationNode;
    }

    public function handleVisit(Visitable|EnumDeclarationNode $visitable): bool
    {
        /** @var EnumDeclarationNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write($this->indent(), "enum ", $visitable->getName(), " {\n");

        $this->stepIn();
        return true;
    }

    public function handleLeave(Visitable|EnumDeclarationNode $visitable): void
    {
        $this->stepOut();

        /** @var EnumDeclarationNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        if ($visitable->getDefault() != "") {
            $this->write($this->indent(), "} = ", $visitable->getDefault(), ";\n");
        } else {
            $this->write($this->indent(), "}\n");
        }
    }
}
