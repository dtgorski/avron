<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\ErrorListNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ErrorListNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof ErrorListNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var ErrorListNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write(" ", $node->getType()->name, " ");

        return true;
    }
}
