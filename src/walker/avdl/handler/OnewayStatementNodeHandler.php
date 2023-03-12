<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\OnewayStatementNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class OnewayStatementNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof OnewayStatementNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var OnewayStatementNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write(" oneway");

        return false;
    }
}
