<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\EnumConstantNode;

/**
 * @covers \Avron\Idl\EnumConstantNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\EnumConstantNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class EnumConstantNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new EnumConstantNodeHandler($ctx);
        $node = new EnumConstantNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new EnumConstantNodeHandler($ctx);
        $handler->handleVisit(new EnumConstantNode("foo"));

        $this->assertEquals("foo", $writer->getBuffer());
    }

    public function testHandleVisitWithCommas(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAstNode();
        $node->addNode(new EnumConstantNode("foo"));
        $node->addNode(new EnumConstantNode("bar"));

        $handler = new EnumConstantNodeHandler($ctx);

        $handler->handleVisit($node->nodeAt(0));
        $handler->handleLeave($node->nodeAt(0));
        $this->assertEquals("foo,\n", $writer->getBuffer());

        $handler->handleVisit($node->nodeAt(1));
        $handler->handleLeave($node->nodeAt(1));
        $this->assertEquals("foo,\nbar\n", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new EnumConstantNodeHandler($ctx);
        $handler->handleLeave(new EnumConstantNode("foo"));

        $this->assertEquals("\n", $writer->getBuffer());
    }
}
