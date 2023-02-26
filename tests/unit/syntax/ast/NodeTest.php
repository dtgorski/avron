<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\api\Visitable;
use lengo\avron\api\Visitor;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @covers \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class NodeTest extends TestCase
{
    public function testAccept(): void
    {
        $node = (new TestNode("A"))
            ->addNode(
                (new TestNode("B"))
                    ->addNode(new TestNode("C"))
            )->addNode(
                (new TestNode("D"))
                    ->addNode(new TestNode("E"))
                    ->addNode(new TestNode("F"))
            )->addNode(
                (new TestNode("G"))
                    ->addNode(new TestNode("H"))
                    ->addNode(new TestNode("I"))
                    ->addNode(new TestNode("J"))
            );

        $visitor = new TestVisitor();
        $this->assertSame("", $visitor->thread);
        $node->accept($visitor);
        $this->assertSame("ABCDEFGHIJ", $visitor->thread);
    }

    public function testParentChildSibling(): void
    {
        $A = (new TestNode())
            ->addNode(
                ($B = new TestNode())
                    ->addNode($C = new TestNode())
            )->addNode(
                ($D = new TestNode())
                    ->addNode($E = new TestNode())
                    ->addNode($F = new TestNode())
            )->addNode(
                ($G = new TestNode())
                    ->addNode($H = new TestNode())
                    ->addNode($I = new TestNode())
                    ->addNode($J = new TestNode())
            );

        // getParent()
        $this->assertSame($A, $B->getParent());
        $this->assertSame($B, $C->getParent());

        // getChildCount()
        $this->assertEquals(3, $A->getChildCount());
        $this->assertEquals(1, $B->getChildCount());
        $this->assertEquals(2, $D->getChildCount());
        $this->assertEquals(3, $G->getChildCount());

        // getChildIndex()
        $this->assertEquals(-1, $A->getChildIndex());
        $this->assertEquals(0, $B->getChildIndex());
        $this->assertEquals(1, $D->getChildIndex());
        $this->assertEquals(0, $C->getChildIndex());
        $this->assertEquals(0, $E->getChildIndex());
        $this->assertEquals(1, $F->getChildIndex());
        $this->assertEquals(0, $H->getChildIndex());
        $this->assertEquals(1, $I->getChildIndex());
        $this->assertEquals(2, $J->getChildIndex());

        // getPrevSibling()
        $this->assertSame(null, $A->getPrevSibling());
        $this->assertSame(null, $B->getPrevSibling());
        $this->assertSame(null, $C->getPrevSibling());
        $this->assertSame(null, $E->getPrevSibling());
        $this->assertSame(null, $H->getPrevSibling());
        $this->assertSame($E, $F->getPrevSibling());
        $this->assertSame($H, $I->getPrevSibling());
        $this->assertSame($I, $J->getPrevSibling());

        // getNextSibling()
        $this->assertSame(null, $A->getNextSibling());
        $this->assertSame(null, $C->getNextSibling());
        $this->assertSame(null, $F->getNextSibling());
        $this->assertSame(null, $J->getNextSibling());
        $this->assertSame($I, $H->getNextSibling());
        $this->assertSame($J, $I->getNextSibling());
        $this->assertSame($D, $B->getNextSibling());
        $this->assertSame($G, $D->getNextSibling());
    }

    public function testAddingNullNodes(): void
    {
        $node = new TestNode();
        $this->assertSame(0, $node->getChildCount());
        $node->addNode(null);
        $this->assertSame(0, $node->getChildCount());
    }

    public function testAddingNodesWithParents(): void
    {
        $this->expectException(RuntimeException::class);
        (new TestNode())->addNode($child = new TestNode());
        $other = new TestNode();
        $other->addNode($child);
    }

    public function testGetProperties(): void
    {
        $props = Properties::fromArray([]);
        $this->assertSame($props, (new TestNode())->setProperties($props)->getProperties());
    }

    public function testStringable(): void
    {
        $this->assertSame("[lengo\avron\ast\TestNode]", (string)new TestNode());
    }
}

// phpcs:ignore
class TestNode extends Node
{
    public function __construct(readonly string $name = "")
    {
        parent::__construct();
    }
}

// phpcs:ignore
class TestVisitor implements Visitor
{
    public string $thread = "";

    public function visit(Visitable|TestNode $node): bool
    {
        $this->thread .= $node->name;
        return true;
    }

    public function leave(Visitable $node): void
    {
    }
}
