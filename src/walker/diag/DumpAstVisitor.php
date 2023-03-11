<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Diag;

use Avron\Api\Visitable;
use Avron\Api\Visitor;
use Avron\Api\Writer;
use Avron\Ast\AstNode;
use Avron\StandardWriter;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class DumpAstVisitor implements Visitor
{
    public function __construct(private readonly Writer $writer = new StandardWriter(STDIN))
    {
    }

    public function visit(Visitable|AstNode $node): bool
    {
        /** @var AstNode $node calms static analysis down. */
        $parts = explode("\\", get_class($node));
        $edges = $this->edges($node);
        $name = $parts[sizeof($parts) - 1];

        $this->writer->write($edges, $name, "\n");

        return true;
    }

    public function leave(Visitable|AstNode $node): void
    {
    }

    private function edges(AstNode $node): string
    {
        $edge = $node->parentNode()
            ? ($node->nextNode() ? "├── " : "└── ")
            : "";
        while ($node = $node->parentNode()) {
            $edge = ($node->nextNode() ? "│   " : "    ") . $edge;
        }
        return $edge;
    }
}
