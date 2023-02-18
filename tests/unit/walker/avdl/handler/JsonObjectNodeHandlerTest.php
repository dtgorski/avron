<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\JsonObjectNode;

/**
 * @covers \lengo\avron\avdl\JsonObjectNodeHandler
 * @uses   \lengo\avron\ast\JsonObjectNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class JsonObjectNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new JsonObjectNodeHandler($ctx);
        $node = new JsonObjectNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new JsonObjectNodeHandler($ctx);
        $handler->handleVisit(new JsonObjectNode());

        $this->assertEquals("{", $writer->getBuffer());
    }

    public function testHandleVisitWithPrevSibling(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAnonymousNode();
        $node->addNode(new JsonObjectNode());
        $node->addNode(new JsonObjectNode());

        $handler = new JsonObjectNodeHandler($ctx);
        $handler->handleVisit($node->getChildNodeAt(1));

        $this->assertEquals(", {", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new JsonObjectNodeHandler($ctx);
        $handler->handleLeave(new JsonObjectNode());

        $this->assertEquals("}", $writer->getBuffer());
    }
}
