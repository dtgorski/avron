<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\TypeNode;

/**
 * @covers \lengo\avron\avdl\TypeNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\TypeNode
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
