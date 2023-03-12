<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\Api\Visitable;
use Avron\Api\Visitor;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @covers \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 */
class AstNodeTest extends TestCase
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
        $this->assertSame($A, $B->parentNode());
        $this->assertSame($B, $C->parentNode());

        // getChildCount()
        $this->assertSame(3, $A->nodeCount());
        $this->assertSame(1, $B->nodeCount());
        $this->assertSame(2, $D->nodeCount());
        $this->assertSame(3, $G->nodeCount());

        // getChildIndex()
        $this->assertEquals(-1, $A->nodeIndex());
        $this->assertSame(0, $B->nodeIndex());
        $this->assertSame(1, $D->nodeIndex());
        $this->assertSame(0, $C->nodeIndex());
        $this->assertSame(0, $E->nodeIndex());
        $this->assertSame(1, $F->nodeIndex());
        $this->assertSame(0, $H->nodeIndex());
        $this->assertSame(1, $I->nodeIndex());
        $this->assertSame(2, $J->nodeIndex());

        // getPrevSibling()
        $this->assertSame(null, $A->prevNode());
        $this->assertSame(null, $B->prevNode());
        $this->assertSame(null, $C->prevNode());
        $this->assertSame(null, $E->prevNode());
        $this->assertSame(null, $H->prevNode());
        $this->assertSame($E, $F->prevNode());
        $this->assertSame($H, $I->prevNode());
        $this->assertSame($I, $J->prevNode());

        // getNextSibling()
        $this->assertSame(null, $A->nextNode());
        $this->assertSame(null, $C->nextNode());
        $this->assertSame(null, $F->nextNode());
        $this->assertSame(null, $J->nextNode());
        $this->assertSame($I, $H->nextNode());
        $this->assertSame($J, $I->nextNode());
        $this->assertSame($D, $B->nextNode());
        $this->assertSame($G, $D->nextNode());
    }

    public function testAddingNullNodes(): void
    {
        $node = new TestNode();
        $this->assertSame(0, $node->nodeCount());
        $node->addNode(null);
        $this->assertSame(0, $node->nodeCount());
    }

    public function testAddingNodesWithParents(): void
    {
        $this->expectException(RuntimeException::class);
        (new TestNode())->addNode($child = new TestNode());
        $other = new TestNode();
        $other->addNode($child);
    }
}

// phpcs:ignore
class TestNode extends AstNode
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

    public function visit(Visitable $visitable): bool
    {
        $this->thread .= $visitable->name;
        return true;
    }

    public function leave(Visitable $visitable): void
    {
    }
}
