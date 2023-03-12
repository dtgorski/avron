<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\JsonArrayNode;

/**
 * @covers \Avron\Idl\JsonArrayNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\JsonArrayNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class JsonArrayNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new JsonArrayNodeHandler($ctx);
        $node = new JsonArrayNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new JsonArrayNodeHandler($ctx);
        $handler->handleVisit(new JsonArrayNode());

        $this->assertEquals("[", $writer->getBuffer());
    }

    public function testHandleVisitWithPrevSibling(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $node = $this->createAstNode();
        $node->addNode(new JsonArrayNode());
        $node->addNode(new JsonArrayNode());

        $handler = new JsonArrayNodeHandler($ctx);
        $handler->handleVisit($node->nodeAt(1));

        $this->assertEquals(", [", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new JsonArrayNodeHandler($ctx);
        $handler->handleLeave(new JsonArrayNode());

        $this->assertEquals("]", $writer->getBuffer());
    }
}
