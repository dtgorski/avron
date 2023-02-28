<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\EnumConstantNode;

/**
 * @covers \lengo\avron\avdl\EnumConstantNodeHandler
 * @uses   \lengo\avron\ast\EnumConstantNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class EnumConstantNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new EnumConstantNodeHandler($ctx);
        $node = new EnumConstantNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new EnumConstantNodeHandler($ctx);
        $handler->handleVisit(new EnumConstantNode("foo"));

        $this->assertEquals("foo", $writer->getBuffer());
    }

    public function testHandleVisitWithCommas(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAnonymousNode();
        $node->addNode(new EnumConstantNode("foo"));
        $node->addNode(new EnumConstantNode("bar"));

        $handler = new EnumConstantNodeHandler($ctx);

        $handler->handleVisit($node->getChildNodeAt(0));
        $handler->handleLeave($node->getChildNodeAt(0));
        $this->assertEquals("foo,\n", $writer->getBuffer());

        $handler->handleVisit($node->getChildNodeAt(1));
        $handler->handleLeave($node->getChildNodeAt(1));
        $this->assertEquals("foo,\nbar\n", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new EnumConstantNodeHandler($ctx);
        $handler->handleLeave(new EnumConstantNode("foo"));

        $this->assertEquals("\n", $writer->getBuffer());
    }
}
