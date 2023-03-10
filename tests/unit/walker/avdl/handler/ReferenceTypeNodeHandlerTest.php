<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\ReferenceTypeNode;

/**
 * @covers \Avron\Idl\ReferenceTypeNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Ast\ReferenceTypeNode
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class ReferenceTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new ReferenceTypeNodeHandler($ctx);
        $node = new ReferenceTypeNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ReferenceTypeNodeHandler($ctx);
        $handler->handleVisit(new ReferenceTypeNode("name"));

        $this->assertEquals("name", $writer->getBuffer());
    }
}
