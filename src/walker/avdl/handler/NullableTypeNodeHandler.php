<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Visitable;
use Avron\Ast\NullableTypeNode;
use Avron\Ast\TypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class NullableTypeNodeHandler extends TypeNodeHandler
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof NullableTypeNode;
    }

    public function handleLeave(Visitable $visitable): void
    {
        /** @var TypeNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write("?");
    }
}
