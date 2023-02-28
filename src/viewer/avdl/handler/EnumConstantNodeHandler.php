<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\API\Visitable;
use Avron\AST\EnumConstantNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class EnumConstantNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof EnumConstantNode;
    }

    public function handleVisit(Visitable|EnumConstantNode $visitable): bool
    {
        /** @var EnumConstantNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->write($this->indent(), $visitable->getName());
        return true;
    }

    public function handleLeave(Visitable|EnumConstantNode $visitable): void
    {
        /** @var EnumConstantNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        if ($visitable->getNextSibling()) {
            $this->write(",");
        }
        $this->write("\n");
    }
}
