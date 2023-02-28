<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\API\Visitable;
use Avron\AST\ProtocolDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
