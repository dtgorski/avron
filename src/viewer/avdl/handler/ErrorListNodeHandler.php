<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\ErrorListNode;

/** @internal This class is not part of the official API. */
class ErrorListNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof ErrorListNode;
    }

    public function handleVisit(Visitable|ErrorListNode $visitable): bool
    {
        /** @var ErrorListNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write(" ", $visitable->getType()->name, " ");

        return true;
    }
}
