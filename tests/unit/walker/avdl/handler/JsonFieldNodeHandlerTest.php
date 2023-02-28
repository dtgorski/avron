<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\JsonFieldNode;

/**
 * @covers \Avron\AVDL\JsonFieldNodeHandler
 * @uses   \Avron\AST\JsonFieldNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class JsonFieldNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new JsonFieldNodeHandler($ctx);
        $node = new JsonFieldNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new JsonFieldNodeHandler($ctx);
        $handler->handleVisit(new JsonFieldNode("name"));

        $this->assertEquals('"name":', $writer->getBuffer());
    }

    public function testHandleVisitWithPrevSibling(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAnonymousNode();
        $node->addNode(new JsonFieldNode("name"));
        $node->addNode(new JsonFieldNode("name"));

        $handler = new JsonFieldNodeHandler($ctx);
        $handler->handleVisit($node->getChildNodeAt(1));

        $this->assertEquals(', "name":', $writer->getBuffer());
    }
}
