<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\EnumDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class EnumDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof EnumDeclarationNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var EnumDeclarationNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write($this->indent(), "enum ", $node->getName(), " {\n");

        $this->stepIn();

        return true;
    }

    public function handleLeave(Node $node): void
    {
        $this->stepOut();

        /** @var EnumDeclarationNode $node calms static analysis down. */
        parent::handleLeave($node);

        if ($node->getDefault() != "") {
            $this->write($this->indent(), "} = ", $node->getDefault(), ";\n");
        } else {
            $this->write($this->indent(), "}\n");
        }
    }
}
