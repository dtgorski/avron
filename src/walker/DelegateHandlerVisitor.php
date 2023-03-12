<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Walker;

use Avron\Api\Node;
use Avron\Api\NodeHandler;
use Avron\Api\Visitable;
use Avron\Api\Visitor;

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

    public function visit(Visitable $visitable): bool
    {
        /** @var Node $visitable */
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($visitable)) {
                return $handler->handleVisit($visitable);
            }
        }
        return true;
    }

    public function leave(Visitable $visitable): void
    {
        /** @var Node $visitable */
        foreach ($this->handlers as $handler) {
            if ($handler->canHandle($visitable)) {
                $handler->handleLeave($visitable);
                break;
            }
        }
    }
}
