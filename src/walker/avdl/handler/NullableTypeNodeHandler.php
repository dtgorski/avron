<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\NullableTypeNode;
use Avron\Ast\TypeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class NullableTypeNodeHandler extends TypeNodeHandler
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof NullableTypeNode;
    }

    public function handleLeave(Node $node): void
    {
        /** @var TypeNode $node calms static analysis down. */
        parent::handleLeave($node);

        $this->write("?");
    }
}
