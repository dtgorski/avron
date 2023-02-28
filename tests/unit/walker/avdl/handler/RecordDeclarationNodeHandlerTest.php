<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\RecordDeclarationNode;

/**
 * @covers \Avron\AVDL\RecordDeclarationNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\RecordDeclarationNode
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class RecordDeclarationNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new RecordDeclarationNodeHandler($ctx);
        $node = new RecordDeclarationNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new RecordDeclarationNodeHandler($ctx);
        $handler->handleVisit(new RecordDeclarationNode("name"));

        $this->assertEquals("\nrecord name {\n", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new RecordDeclarationNodeHandler($ctx);
        $handler->handleLeave(new RecordDeclarationNode(""));

        $this->assertEquals("}\n", $writer->getBuffer());
    }
}
