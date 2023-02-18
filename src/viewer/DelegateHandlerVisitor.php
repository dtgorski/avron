<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\walker;

use lengo\avron\api\NodeHandler;
use lengo\avron\api\Visitable;
use lengo\avron\api\Visitor;

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
