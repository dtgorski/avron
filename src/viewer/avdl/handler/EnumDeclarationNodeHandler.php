<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\API\Visitable;
use Avron\AST\EnumDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
