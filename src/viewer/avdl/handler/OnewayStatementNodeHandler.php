<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\OnewayStatementNode;

/** @internal This class is not part of the official API. */
class OnewayStatementNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof OnewayStatementNode;
    }

    public function handleVisit(Visitable|OnewayStatementNode $visitable): bool
    {
        /** @var OnewayStatementNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write(" oneway");

        return false;
    }
}
