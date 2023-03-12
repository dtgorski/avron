<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\ErrorDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ErrorDeclarationNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof ErrorDeclarationNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var ErrorDeclarationNode $node calms static analysis down. */
        parent::handleVisit($node);

        $this->write($this->indent(), "error ", $node->getName(), " {\n");

        $this->stepIn();

        return true;
    }

    public function handleLeave(Node $node): void
    {
        $this->stepOut();

        /** @var ErrorDeclarationNode $node calms static analysis down. */
        parent::handleLeave($node);

        $this->write($this->indent(), "}\n");
    }
}
