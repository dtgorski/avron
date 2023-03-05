<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\JsonFieldNode;

/**
 * @covers \Avron\Idl\JsonFieldNodeHandler
 * @uses   \Avron\Ast\JsonFieldNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Idl\HandlerAbstract
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
