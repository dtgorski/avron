<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\MapTypeNode;

/**
 * @covers \Avron\Idl\MapTypeNodeHandler
 * @uses   \Avron\Ast\MapTypeNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Idl\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
