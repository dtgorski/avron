<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\RecordDeclarationNode;

/**
 * @covers \lengo\avron\avdl\RecordDeclarationNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\RecordDeclarationNode
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
