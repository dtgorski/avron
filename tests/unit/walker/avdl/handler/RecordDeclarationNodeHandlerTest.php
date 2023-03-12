<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\RecordDeclarationNode;

/**
 * @covers \Avron\Idl\RecordDeclarationNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Ast\RecordDeclarationNode
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
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
