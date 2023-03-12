<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\FixedDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class FixedDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof FixedDeclarationNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var FixedDeclarationNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write($this->indent(), "fixed ", $node->getName(), "(", $node->getValue(), ");\n");

        return false;
    }
}
