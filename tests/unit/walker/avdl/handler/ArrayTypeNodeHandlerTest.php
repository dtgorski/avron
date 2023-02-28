<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\ArrayTypeNode;

/**
 * @covers \Avron\IDL\ArrayTypeNodeHandler
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\IDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class ArrayTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new ArrayTypeNodeHandler($ctx);
        $node = new ArrayTypeNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ArrayTypeNodeHandler($ctx);
        $handler->handleVisit(new ArrayTypeNode());

        $this->assertEquals("array<", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ArrayTypeNodeHandler($ctx);
        $handler->handleLeave(new ArrayTypeNode());

        $this->assertEquals(">", $writer->getBuffer());
    }
}
