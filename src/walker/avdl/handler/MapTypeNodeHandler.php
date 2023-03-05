<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\MapTypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class MapTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof MapTypeNode;
    }

    public function handleVisit(Visitable|MapTypeNode $visitable): bool
    {
        /** @var MapTypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write("map<");

        return true;
    }

    public function handleLeave(Visitable|MapTypeNode $visitable): void
    {
        /** @var MapTypeNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write(">");
    }
}
