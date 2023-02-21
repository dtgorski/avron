<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\ReferenceTypeNode;

/** @internal This class is not part of the official API. */
class ReferenceTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof ReferenceTypeNode;
    }

    public function handleVisit(Visitable|ReferenceTypeNode $visitable): bool
    {
        /** @var ReferenceTypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->writePropertiesSingleLine($visitable->getProperties());
        $this->write($visitable->getName());

        return true;
    }
}
