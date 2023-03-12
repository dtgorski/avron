<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\DecimalTypeNode;

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

    public function handleVisit(Visitable $visitable): bool
    {
        parent::handleVisit($visitable);

        /** @var DecimalTypeNode $visitable calms static analysis down. */
        $this->writePropertiesSingleLine($visitable->getProperties());

        $this->write("decimal(", $visitable->getPrecision(), ", ", $visitable->getScale(), ")");

        return false;
    }
}
