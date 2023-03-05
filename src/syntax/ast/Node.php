<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\Api\Visitable;
use Avron\Api\Visitor;
use RuntimeException;
use Stringable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
abstract class Node implements Visitable, Stringable
{
    private Properties $properties;

    private ?Node $parent = null;

    /** @var Node[] */
    private array $nodes = [];

    public function __construct()
    {
        $this->properties = Properties::fromArray([]);
    }

    /** Apply visitor to sub-tree. */
    public function accept(Visitor $visitor): void
    {
        if ($visitor->visit($this)) {
            foreach ($this->getChildNodes() as $node) {
                $node->accept($visitor);
            }
        }
        $visitor->leave($this);
    }

    /** Appends node(s) to already existing child nodes. Sets child-parent relationship. */
    public function addNode(?Node ...$nodes): Node
    {
        foreach ($nodes as $node) {
            if ($node === null) {
                continue;
            }
            if ($node->getParent()) {
                throw new RuntimeException("unexpected, node already has a parent");
            }
            $node->setParent($this);
            $this->nodes[] = $node;
        }
        return $this;
    }

    /** Returns the parent node or null, if the node has no parent. */
    public function getParent(): ?Node
    {
        return $this->parent;
    }

    /** Friend method. Do not use in your client code. */
    public function setParent(?Node $node): Node
    {
        $this->parent = $node;
        return $this;
    }

    /** @return Node[] */
    public function getChildNodes(): array
    {
        return $this->nodes;
    }

    public function getChildCount(): int
    {
        return sizeof($this->nodes);
    }

    /** @return ?Node null, when previous sibling does not exist. */
    public function getPrevSibling(): ?Node
    {
        return $this->getParent()?->getChildNodeAt($this->getChildIndex() - 1);
    }

    /** @return ?Node null, when next sibling does not exist. */
    public function getNextSibling(): ?Node
    {
        return $this->getParent()?->getChildNodeAt($this->getChildIndex() + 1);
    }

    public function getChildNodeAt(int $i): ?Node
    {
        return $i >= 0 && $i < sizeof($this->nodes) ? $this->nodes[$i] : null;
    }

    public function getChildIndex(): int
    {
        if (($parent = $this->getParent()) === null) {
            return -1;
        }
        return is_int($idx = array_search($this, $parent->getChildNodes(), true))
            ? $idx
            : -1;
    }

    /** @return Properties */
    public function getProperties(): Properties
    {
        return $this->properties;
    }

    public function setProperties(Properties $properties): Node
    {
        $this->properties = $properties;
        return $this;
    }

    public function __toString(): string
    {
        return sprintf("[%s]", get_class($this));
    }
}
