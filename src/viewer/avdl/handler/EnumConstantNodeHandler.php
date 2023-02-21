<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\EnumConstantNode;

/** @internal This class is not part of the official API. */
class EnumConstantNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof EnumConstantNode;
    }

    public function handleVisit(Visitable|EnumConstantNode $visitable): bool
    {
        /** @var EnumConstantNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write($this->indent(), $visitable->getName());
        return true;
    }

    public function handleLeave(Visitable|EnumConstantNode $visitable): void
    {
        /** @var EnumConstantNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        if ($visitable->getNextSibling()) {
            $this->write(",");
        }
        $this->write("\n");
    }
}
