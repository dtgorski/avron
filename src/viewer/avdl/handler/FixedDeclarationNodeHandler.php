<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\FixedDeclarationNode;

/** @internal This class is not part of the official API. */
class FixedDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof FixedDeclarationNode;
    }

    public function handleVisit(Visitable|FixedDeclarationNode $visitable): bool
    {
        /** @var FixedDeclarationNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write($this->indent(), "fixed ", $visitable->getName(), "(", $visitable->getValue(), ");\n");

        return false;
    }
}
