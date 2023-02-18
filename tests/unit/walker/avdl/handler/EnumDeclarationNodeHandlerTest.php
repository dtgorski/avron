<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\EnumDeclarationNode;

/**
 * @covers \lengo\avron\avdl\EnumDeclarationNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\EnumDeclarationNode
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class EnumDeclarationNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new EnumDeclarationNodeHandler($ctx);
        $node = new EnumDeclarationNode("", "");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new EnumDeclarationNodeHandler($ctx);
        $handler->handleVisit(new EnumDeclarationNode("name", ""));

        $this->assertEquals("\nenum name {\n", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new EnumDeclarationNodeHandler($ctx);
        $handler->handleLeave(new EnumDeclarationNode("", "default"));

        $this->assertEquals("} = default;\n", $writer->getBuffer());
    }

    public function testHandleLeaveWithoutDefault(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new EnumDeclarationNodeHandler($ctx);
        $handler->handleLeave(new EnumDeclarationNode("", ""));

        $this->assertEquals("}\n", $writer->getBuffer());
    }
}
