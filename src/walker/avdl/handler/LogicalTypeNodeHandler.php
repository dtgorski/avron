<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\LogicalTypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class LogicalTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof LogicalTypeNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var LogicalTypeNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->writePropertiesSingleLine($node->getProperties());
        $this->write($node->getType()->name);

        return false;
    }
}
