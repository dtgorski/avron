<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\ErrorListNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
