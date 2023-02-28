<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\FormalParameterNode;

/**
 * @covers \lengo\avron\avdl\FormalParameterNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\FormalParameterNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
