<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\FormalParameterNode;

/**
 * @covers \Avron\Idl\FormalParameterNodeHandler
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\FormalParameterNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Idl\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class FormalParameterNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new FormalParameterNodeHandler($ctx);
        $node = new FormalParameterNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new FormalParameterNodeHandler($ctx);
        $handler->handleVisit(new FormalParameterNode());

        $this->assertEquals("", $writer->getBuffer());
    }

    public function testHandleVisitWithPrevSibling(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAnonymousNode();
        $node->addNode(new FormalParameterNode());
        $node->addNode(new FormalParameterNode());

        $handler = new FormalParameterNodeHandler($ctx);
        $handler->handleVisit($node->getChildNodeAt(1));

        $this->assertEquals(", ", $writer->getBuffer());
    }
}
