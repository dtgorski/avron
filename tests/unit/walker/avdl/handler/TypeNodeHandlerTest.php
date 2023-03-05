<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\TypeNode;

/**
 * @covers \Avron\Idl\TypeNodeHandler
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Ast\TypeNode
 * @uses   \Avron\Idl\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class TypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new TypeNodeHandler($ctx);
        $node = new TypeNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new TypeNodeHandler($ctx);
        $handler->handleVisit(new TypeNode());

        $this->assertEquals("", $writer->getBuffer());
    }

    public function testHandleVisitWithDeclarationParent(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $decl = $this->createDeclarationNode();
        $decl->addNode($node = new TypeNode());

        $handler = new TypeNodeHandler($ctx);
        $handler->handleVisit($node);

        $this->assertEquals("", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new TypeNodeHandler($ctx);
        $handler->handleLeave(new TypeNode());

        $this->assertEquals("", $writer->getBuffer());
    }

    public function testHandleLeaveWithNextSibling(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAnonymousNode();
        $node->addNode(new TypeNode());
        $node->addNode(new TypeNode());

        $handler = new TypeNodeHandler($ctx);
        $handler->handleLeave($node->getChildNodeAt(0));

        $this->assertEquals(", ", $writer->getBuffer());
    }
}
