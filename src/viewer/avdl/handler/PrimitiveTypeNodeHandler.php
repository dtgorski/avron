<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\PrimitiveTypeNode;

class PrimitiveTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof PrimitiveTypeNode;
    }

    public function handleVisit(Visitable|PrimitiveTypeNode $visitable): bool
    {
        /** @var PrimitiveTypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->writePropertiesSingleLine($visitable->getProperties());
        $this->write($visitable->getType()->name);

        return false;
    }
}
