<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\JsonFieldNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class JsonFieldNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof JsonFieldNode;
    }

    public function handleVisit(Visitable|JsonFieldNode $visitable): bool
    {
        /** @var JsonFieldNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->getPrevSibling()) {
            $this->write(", ");
        }
        $this->write('"', $visitable->getName(), '":');

        return true;
    }
}