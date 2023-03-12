<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\EnumDeclarationNode;

/**
 * @covers \Avron\Idl\EnumDeclarationNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\EnumDeclarationNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
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
