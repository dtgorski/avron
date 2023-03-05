<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\JsonObjectNode;

/**
 * @covers \Avron\Idl\JsonObjectNodeHandler
 * @uses   \Avron\Ast\JsonObjectNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Idl\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
