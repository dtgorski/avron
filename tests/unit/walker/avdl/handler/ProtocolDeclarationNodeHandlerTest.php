<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\ProtocolDeclarationNode;

/**
 * @covers \Avron\AVDL\ProtocolDeclarationNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\ProtocolDeclarationNode
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
