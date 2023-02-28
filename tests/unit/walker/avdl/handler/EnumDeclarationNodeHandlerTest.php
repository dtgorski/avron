<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\EnumDeclarationNode;

/**
 * @covers \Avron\IDL\EnumDeclarationNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\EnumDeclarationNode
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Node
 * @uses   \Avron\IDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
