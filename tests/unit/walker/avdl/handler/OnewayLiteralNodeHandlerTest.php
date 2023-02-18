<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\OnewayStatementNode;

/**
 * @covers \lengo\avron\avdl\OnewayStatementNodeHandler
 * @covers \lengo\avron\ast\OnewayStatementNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class OnewayLiteralNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new OnewayStatementNodeHandler($ctx);
        $node = new OnewayStatementNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new OnewayStatementNodeHandler($ctx);
        $handler->handleVisit(new OnewayStatementNode());

        $this->assertEquals(" oneway", $writer->getBuffer());
    }
}
