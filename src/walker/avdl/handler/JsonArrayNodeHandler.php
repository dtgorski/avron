<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\JsonArrayNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class JsonArrayNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof JsonArrayNode;
    }

    public function handleVisit(Visitable $visitable): bool
    {
        /** @var JsonArrayNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->prevNode()) {
            $this->write(", ");
        }
        $this->write("[");

        return true;
    }

    public function handleLeave(Visitable $visitable): void
    {
        /** @var JsonArrayNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write("]");
    }
}
