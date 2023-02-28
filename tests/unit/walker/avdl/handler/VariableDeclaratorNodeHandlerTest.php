<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\VariableDeclaratorNode;

/**
 * @covers \Avron\IDL\VariableDeclaratorNodeHandler
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\VariableDeclaratorNode
 * @uses   \Avron\IDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class VariableDeclaratorNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new VariableDeclaratorNodeHandler($ctx);
        $node = new VariableDeclaratorNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new VariableDeclaratorNodeHandler($ctx);
        $handler->handleVisit(new VariableDeclaratorNode("name"));

        $this->assertEquals(" name", $writer->getBuffer());
    }

    public function testHandleVisitWithChild(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = new VariableDeclaratorNode("name");
        $node->addNode($this->createAnonymousNode());

        $handler = new VariableDeclaratorNodeHandler($ctx);
        $handler->handleVisit($node);

        $this->assertEquals(" name = ", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new VariableDeclaratorNodeHandler($ctx);
        $handler->handleLeave(new VariableDeclaratorNode(""));

        $this->assertEquals("", $writer->getBuffer());
    }

    public function testHandleLeaveWithNextSibling(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAnonymousNode();
        $node->addNode(new VariableDeclaratorNode(""));
        $node->addNode(new VariableDeclaratorNode(""));

        $handler = new VariableDeclaratorNodeHandler($ctx);
        $handler->handleLeave($node->getChildNodeAt(0));

        $this->assertEquals(",", $writer->getBuffer());
    }
}
