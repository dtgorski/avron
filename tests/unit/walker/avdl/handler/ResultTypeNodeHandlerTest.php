<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\ResultTypeNode;

/**
 * @covers \lengo\avron\avdl\ResultTypeNodeHandler
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\ResultTypeNode
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class ResultTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new ResultTypeNodeHandler($ctx);
        $node = new ResultTypeNode(true);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisitVoid(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ResultTypeNodeHandler($ctx);
        $handler->handleVisit(new ResultTypeNode(true));

        $this->assertEquals("void", $writer->getBuffer());
    }

    public function testHandleVisitNonVoid(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ResultTypeNodeHandler($ctx);
        $handler->handleVisit(new ResultTypeNode(false));

        $this->assertEquals("", $writer->getBuffer());
    }
}
