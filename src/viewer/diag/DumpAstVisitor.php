<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\diag;

use lengo\avron\api\Visitable;
use lengo\avron\api\Visitor;
use lengo\avron\api\Writer;
use lengo\avron\ast\Node;
use lengo\avron\StandardWriter;

/** @internal This class is not part of the official API. */
class DumpAstVisitor implements Visitor
{
    public function __construct(private readonly Writer $writer = new StandardWriter(STDIN))
    {
    }

    public function visit(Visitable|Node $node): bool
    {
        /** @var Node $node calms static analysis down. */
        $parts = explode("\\", get_class($node));
        $edges = $this->edges($node);
        $name = $parts[sizeof($parts) - 1];

        $this->writer->write($edges, $name, "\n");

        return true;
    }

    public function leave(Visitable|Node $node): void
    {
    }

    private function edges(Node $node): string
    {
        $edge = $node->getParent()
            ? ($node->getNextSibling() ? "├── " : "└── ")
            : "";
        while ($node = $node->getParent()) {
            $edge = ($node->getNextSibling() ? "│   " : "    ") . $edge;
        }
        return $edge;
    }
}
