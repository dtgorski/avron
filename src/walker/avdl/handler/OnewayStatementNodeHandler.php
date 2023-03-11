<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\OnewayStatementNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class OnewayStatementNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof OnewayStatementNode;
    }

    public function handleVisit(Visitable $visitable): bool
    {
        /** @var OnewayStatementNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write(" oneway");

        return false;
    }
}
