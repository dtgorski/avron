<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\OnewayStatementNode;

/**
 * @covers \Avron\Idl\OnewayStatementNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\OnewayStatementNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class OnewayStatementNodeHandlerTest extends HandlerTestCase
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
