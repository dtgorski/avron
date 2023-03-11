<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\ProtocolDeclarationNode;

/**
 * @covers \Avron\Idl\ProtocolDeclarationNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Ast\ProtocolDeclarationNode
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class ProtocolDeclarationNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new ProtocolDeclarationNodeHandler($ctx);
        $node = new ProtocolDeclarationNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ProtocolDeclarationNodeHandler($ctx);
        $handler->handleVisit(new ProtocolDeclarationNode("name"));

        $this->assertEquals("protocol name {\n", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ProtocolDeclarationNodeHandler($ctx);
        $handler->handleLeave(new ProtocolDeclarationNode(""));

        $this->assertEquals("}\n", $writer->getBuffer());
    }
}
