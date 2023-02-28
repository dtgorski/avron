<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\ReferenceTypeNode;

/**
 * @covers \Avron\IDL\ReferenceTypeNodeHandler
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\ReferenceTypeNode
 * @uses   \Avron\IDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
