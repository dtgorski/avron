<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\MapTypeNode;

/**
 * @covers \lengo\avron\avdl\MapTypeNodeHandler
 * @uses   \lengo\avron\ast\MapTypeNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class MapTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new MapTypeNodeHandler($ctx);
        $node = new MapTypeNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new MapTypeNodeHandler($ctx);
        $handler->handleVisit(new MapTypeNode());

        $this->assertEquals("map<", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new MapTypeNodeHandler($ctx);
        $handler->handleLeave(new MapTypeNode());

        $this->assertEquals(">", $writer->getBuffer());
    }
}
