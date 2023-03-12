<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\VariableDeclaratorNode;

/**
 * @covers \Avron\Idl\VariableDeclaratorNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Ast\VariableDeclaratorNode
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
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
        $node->addNode($this->createAstNode());

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

        $node = $this->createAstNode();
        $node->addNode(new VariableDeclaratorNode(""));
        $node->addNode(new VariableDeclaratorNode(""));

        $handler = new VariableDeclaratorNodeHandler($ctx);
        $handler->handleLeave($node->nodeAt(0));

        $this->assertEquals(",", $writer->getBuffer());
    }
}
