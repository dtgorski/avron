<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\diag;

use lengo\avron\api\Visitable;
use lengo\avron\api\Visitor;
use lengo\avron\api\Writer;
use lengo\avron\ast\Node;
use lengo\avron\StandardWriter;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
