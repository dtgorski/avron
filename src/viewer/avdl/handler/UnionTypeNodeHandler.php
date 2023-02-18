<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\UnionTypeNode;

class UnionTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof UnionTypeNode;
    }

    public function handleVisit(Visitable|UnionTypeNode $visitable): bool
    {
        /** @var UnionTypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write("union { ");

        return true;
    }

    public function handleLeave(Visitable|UnionTypeNode $visitable): void
    {
        /** @var UnionTypeNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write(" }");
    }
}
