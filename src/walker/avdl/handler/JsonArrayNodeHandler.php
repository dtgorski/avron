<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\JsonArrayNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class JsonArrayNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof JsonArrayNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var JsonArrayNode $node calms static analysis down. */
        parent::handleVisit($node);

        if ($node->prevNode()) {
            $this->write(", ");
        }
        $this->write("[");

        return true;
    }

    public function handleLeave(Node $node): void
    {
        /** @var JsonArrayNode $node calms static analysis down. */
        parent::handleLeave($node);

        $this->write("]");
    }
}
