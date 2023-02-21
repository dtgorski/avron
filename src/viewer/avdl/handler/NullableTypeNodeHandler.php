<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\NullableTypeNode;
use lengo\avron\ast\TypeNode;

/** @internal This class is not part of the official API. */
class NullableTypeNodeHandler extends TypeNodeHandler
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof NullableTypeNode;
    }

    public function handleLeave(Visitable|TypeNode $visitable): void
    {
        /** @var TypeNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write("?");
    }
}
