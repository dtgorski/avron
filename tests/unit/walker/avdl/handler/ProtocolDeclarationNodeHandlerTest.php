<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\ProtocolDeclarationNode;

/**
 * @covers \lengo\avron\avdl\ProtocolDeclarationNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\ProtocolDeclarationNode
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
