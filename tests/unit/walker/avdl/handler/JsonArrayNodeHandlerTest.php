<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\JsonArrayNode;

/**
 * @covers \lengo\avron\avdl\JsonArrayNodeHandler
 * @uses   \lengo\avron\ast\JsonArrayNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class JsonArrayNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new JsonArrayNodeHandler($ctx);
        $node = new JsonArrayNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new JsonArrayNodeHandler($ctx);
        $handler->handleVisit(new JsonArrayNode());

        $this->assertEquals("[", $writer->getBuffer());
    }

    public function testHandleVisitWithPrevSibling(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAnonymousNode();
        $node->addNode(new JsonArrayNode());
        $node->addNode(new JsonArrayNode());

        $handler = new JsonArrayNodeHandler($ctx);
        $handler->handleVisit($node->getChildNodeAt(1));

        $this->assertEquals(", [", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new JsonArrayNodeHandler($ctx);
        $handler->handleLeave(new JsonArrayNode());

        $this->assertEquals("]", $writer->getBuffer());
    }
}
