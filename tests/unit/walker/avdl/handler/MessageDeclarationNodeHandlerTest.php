<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\MessageDeclarationNode;

/**
 * @covers \lengo\avron\avdl\MessageDeclarationNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\MessageDeclarationNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class MessageDeclarationNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new MessageDeclarationNodeHandler($ctx);
        $node = new MessageDeclarationNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new MessageDeclarationNodeHandler($ctx);
        $handler->handleVisit(new MessageDeclarationNode(""));

        $this->assertEquals("\n", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new MessageDeclarationNodeHandler($ctx);
        $handler->handleLeave(new MessageDeclarationNode(""));

        $this->assertEquals(";\n", $writer->getBuffer());
    }
}
