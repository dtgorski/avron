<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\TypeNode;

/**
 * @covers \Avron\IDL\TypeNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\TypeNode
 * @uses   \Avron\IDL\HandlerAbstract
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
