<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\DecimalTypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class DecimalTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof DecimalTypeNode;
    }

    public function handleVisit(Node $node): bool
    {
        parent::handleVisit($node);

        /** @var DecimalTypeNode $node calms static analysis down. */
        $this->writePropertiesSingleLine($node->getProperties());

        $this->write("decimal(", $node->getPrecision(), ", ", $node->getScale(), ")");

        return false;
    }
}
