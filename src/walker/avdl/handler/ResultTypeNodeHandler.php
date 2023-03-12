<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\ResultTypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ResultTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof ResultTypeNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var ResultTypeNode $node calms static analysis down. */
        parent::handleVisit($node);

        if ($node->isVoid()) {
            $this->write("void");
            return false;
        }
        return true;
    }
}
