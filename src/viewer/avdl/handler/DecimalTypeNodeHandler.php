<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\DecimalTypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
