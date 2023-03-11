<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use Avron\Api\TreeNode;
use Avron\Api\Visitor;
use RuntimeException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
abstract class VisitableNode implements TreeNode
{
    private VisitableNode|null $parent = null;

    /** @var VisitableNode[] */
    private array $nodes = [];

    public function __construct()
    {
    }

    public function accept(Visitor $visitor): void
    {
        if ($visitor->visit($this)) {
            foreach ($this->childNodes() as $node) {
                $node->accept($visitor);
            }
        }
        $visitor->leave($this);
    }

    public function addNode(TreeNode|VisitableNode|null ...$nodes): VisitableNode
    {
        foreach ($nodes as $node) {
            if ($node === null) {
                continue;
            }
            if ($node->parentNode()) {
                throw new RuntimeException("unexpected, node already has a parent");
            }
            if (!$node instanceof VisitableNode) {
                throw new RuntimeException("addNode() requires VisitableNode type");
            }
            $node->setParentNode($this);
            $this->nodes[] = $node;
        }
        return $this;
    }

    public function parentNode(): VisitableNode|null
    {
        return $this->parent;
    }

    /** @return VisitableNode[] */
    public function childNodes(): array
    {
        return $this->nodes;
    }

    public function nodeCount(): int
    {
        return sizeof($this->nodes);
    }

    public function prevNode(): VisitableNode|null
    {
        return $this->parentNode()?->nodeAt($this->nodeIndex() - 1);
    }

    public function nextNode(): VisitableNode|null
    {
        return $this->parentNode()?->nodeAt($this->nodeIndex() + 1);
    }

    public function nodeAt(int $i): VisitableNode|null
    {
        return $i >= 0 && $i < sizeof($this->nodes) ? $this->nodes[$i] : null;
    }

    public function nodeIndex(): int
    {
        if (($parent = $this->parentNode()) === null) {
            return -1;
        }
        return is_int($idx = array_search($this, $parent->childNodes(), true)) ? $idx : -1;
    }

    /** Friend method. Do not use in your client code. */
    public function setParentNode(VisitableNode|null $node): VisitableNode
    {
        $this->parent = $node;
        return $this;
    }
}
