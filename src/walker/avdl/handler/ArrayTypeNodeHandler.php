<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\ArrayTypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ArrayTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof ArrayTypeNode;
    }

    public function handleVisit(Visitable $visitable): bool
    {
        parent::handleVisit($visitable);

        $this->write("array<");
        return true;
    }

    public function handleLeave(Visitable $visitable): void
    {
        parent::handleLeave($visitable);
        $this->write(">");
    }
}
