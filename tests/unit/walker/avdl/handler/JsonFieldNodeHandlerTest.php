<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\JsonFieldNode;

/**
 * @covers \lengo\avron\avdl\JsonFieldNodeHandler
 * @uses   \lengo\avron\ast\JsonFieldNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
