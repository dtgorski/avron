<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\ArrayTypeNode;

/**
 * @covers \lengo\avron\avdl\ArrayTypeNodeHandler
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
