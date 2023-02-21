<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\ResultTypeNode;

/** @internal This class is not part of the official API. */
class ResultTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof ResultTypeNode;
    }

    public function handleVisit(Visitable|ResultTypeNode $visitable): bool
    {
        /** @var ResultTypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->isVoid()) {
            $this->write("void");
            return false;
        }
        return true;
    }
}
