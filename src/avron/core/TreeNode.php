<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use Avron\Api\Node;
use Avron\Api\Visitor;
use RuntimeException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
abstract class TreeNode implements Node
{
    private Node|null $parent = null;

    /** @var Node[] */
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

    public function addNode(Node|null ...$nodes): Node
    {
        foreach ($nodes as $node) {
            if ($node === null) {
                continue;
            }
            if ($node->parentNode()) {
                throw new RuntimeException("unexpected, node already has a parent");
            }
            if ($node instanceof TreeNode) {
                $node->setParentNode($this);
                $this->nodes[] = $node;
            }
        }
        return $this;
    }

    public function parentNode(): Node|null
    {
        return $this->parent;
    }

    /** @return Node[] */
    public function childNodes(): array
    {
        return $this->nodes;
    }

    public function nodeCount(): int
    {
        return sizeof($this->nodes);
    }

    public function prevNode(): Node|null
    {
        return $this->parentNode()?->nodeAt($this->nodeIndex() - 1);
    }

    public function nextNode(): Node|null
    {
        return $this->parentNode()?->nodeAt($this->nodeIndex() + 1);
    }

    public function nodeAt(int $i): Node|null
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
    public function setParentNode(Node|null $node): Node
    {
        $this->parent = $node;
        return $this;
    }
}
