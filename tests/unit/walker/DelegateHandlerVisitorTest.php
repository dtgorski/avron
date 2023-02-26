<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\walker;

use lengo\avron\api\NodeHandler;
use lengo\avron\ast\TestNode;
use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\walker\DelegateHandlerVisitor
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class DelegateHandlerVisitorTest extends TestCase
{
    public function testVisit(): void
    {
        $node = new TestNode();

        $h1 = $this->createMock(NodeHandler::class);
        $h1->method("canHandle")->willReturn(false);
        $h1->method("handleVisit")->willReturn(true);

        $h2 = $this->createMock(NodeHandler::class);
        $h2->method("canHandle")->willReturn(false);
        $h2->method("handleVisit")->willReturn(true);

        $h3 = $this->createMock(NodeHandler::class);
        $h3->method("canHandle")->willReturn(true);
        $h3->method("handleVisit")->willReturn(true);

        $h1->expects($this->never())->method("handleVisit");
        $h2->expects($this->never())->method("handleVisit");
        $h3->expects($this->once())->method("handleVisit")->with($node);

        $visitor = new DelegateHandlerVisitor([$h1, $h2, $h3]);
        $visitor->visit($node);
    }

    public function testReturnsTrue(): void
    {
        $node = new TestNode();
        $visitor = new DelegateHandlerVisitor([]);
        $this->assertTrue($visitor->visit($node));
    }

    public function testLeave(): void
    {
        $node = new TestNode();

        $h1 = $this->createMock(NodeHandler::class);
        $h1->method("canHandle")->willReturn(false);

        $h2 = $this->createMock(NodeHandler::class);
        $h2->method("canHandle")->willReturn(false);

        $h3 = $this->createMock(NodeHandler::class);
        $h3->method("canHandle")->willReturn(true);

        $h1->expects($this->never())->method("handleLeave");
        $h2->expects($this->never())->method("handleLeave");
        $h3->expects($this->once())->method("handleLeave")->with($node);

        $visitor = new DelegateHandlerVisitor([$h1, $h2, $h3]);
        $visitor->leave($node);
    }
}
