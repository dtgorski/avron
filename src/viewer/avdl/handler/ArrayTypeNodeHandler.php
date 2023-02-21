<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\ArrayTypeNode;

/** @internal This class is not part of the official API. */
class ArrayTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof ArrayTypeNode;
    }

    public function handleVisit(Visitable|ArrayTypeNode $visitable): bool
    {
        /** @var ArrayTypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write("array<");

        return true;
    }

    public function handleLeave(Visitable|ArrayTypeNode $visitable): void
    {
        /** @var ArrayTypeNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write(">");
    }
}
