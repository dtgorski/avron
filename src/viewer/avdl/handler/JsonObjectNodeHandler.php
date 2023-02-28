<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\API\Visitable;
use Avron\AST\JsonObjectNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class JsonObjectNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof JsonObjectNode;
    }

    public function handleVisit(Visitable|JsonObjectNode $visitable): bool
    {
        /** @var JsonObjectNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->getPrevSibling()) {
            $this->write(", ");
        }
        $this->write("{");

        return true;
    }

    public function handleLeave(Visitable|JsonObjectNode $visitable): void
    {
        /** @var JsonObjectNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write("}");
    }
}
