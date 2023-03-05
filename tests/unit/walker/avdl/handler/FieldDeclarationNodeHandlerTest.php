<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\FieldDeclarationNode;

/**
 * @covers \Avron\Idl\FieldDeclarationNodeHandler
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\FieldDeclarationNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Idl\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class FieldDeclarationNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new FieldDeclarationNodeHandler($ctx);
        $node = new FieldDeclarationNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new FieldDeclarationNodeHandler($ctx);
        $handler->handleLeave(new FieldDeclarationNode());

        $this->assertEquals(";\n", $writer->getBuffer());
    }
}
