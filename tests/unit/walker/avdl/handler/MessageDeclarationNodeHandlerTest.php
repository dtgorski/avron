<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\MessageDeclarationNode;

/**
 * @covers \Avron\AVDL\MessageDeclarationNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\MessageDeclarationNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
