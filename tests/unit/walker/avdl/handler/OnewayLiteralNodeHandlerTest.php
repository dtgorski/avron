<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\OnewayStatementNode;

/**
 * @covers \Avron\IDL\OnewayStatementNodeHandler
 * @covers \Avron\AST\OnewayStatementNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\IDL\HandlerAbstract
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
