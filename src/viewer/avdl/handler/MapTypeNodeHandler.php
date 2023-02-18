<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\MapTypeNode;

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
