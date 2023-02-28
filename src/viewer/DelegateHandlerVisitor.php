<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Walker;

use Avron\API\NodeHandler;
use Avron\API\Visitable;
use Avron\API\Visitor;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class DelegateHandlerVisitor implements Visitor
{
    /** @param NodeHandler[] $handlers */
    public function __construct(private readonly array $handlers)
    {
    }

    public function visit(Visitable $node): bool
    {
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($node)) {
                return $handler->handleVisit($node);
            }
        }
        return true;
    }

    public function leave(Visitable $node): void
    {
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($node)) {
                $handler->handleLeave($node);
                break;
            }
        }
    }
}
