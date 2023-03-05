<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\ResultTypeNode;

/**
 * @covers \Avron\Idl\ResultTypeNodeHandler
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Ast\ResultTypeNode
 * @uses   \Avron\Idl\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
