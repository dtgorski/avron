<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\API\Visitable;
use Avron\AST\PrimitiveTypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
