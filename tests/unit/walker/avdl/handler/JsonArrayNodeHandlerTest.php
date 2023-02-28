<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\JsonArrayNode;

/**
 * @covers \Avron\IDL\JsonArrayNodeHandler
 * @uses   \Avron\AST\JsonArrayNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\IDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
