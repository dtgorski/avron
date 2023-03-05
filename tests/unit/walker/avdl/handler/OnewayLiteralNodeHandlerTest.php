<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\OnewayStatementNode;

/**
 * @covers \Avron\Idl\OnewayStatementNodeHandler
 * @covers \Avron\Ast\OnewayStatementNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Idl\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
