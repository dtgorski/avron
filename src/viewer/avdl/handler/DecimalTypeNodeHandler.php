<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\DecimalTypeNode;

/** @internal This class is not part of the official API. */
class DecimalTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof DecimalTypeNode;
    }

    public function handleVisit(Visitable|DecimalTypeNode $visitable): bool
    {
        /** @var DecimalTypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->writePropertiesSingleLine($visitable->getProperties());
        $this->write("decimal(", $visitable->getPrecision(), ", ", $visitable->getScale(), ")");

        return false;
    }
}
