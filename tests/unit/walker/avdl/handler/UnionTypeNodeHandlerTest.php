<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\UnionTypeNode;

/**
 * @covers \lengo\avron\avdl\UnionTypeNodeHandler
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\UnionTypeNode
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class UnionTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new UnionTypeNodeHandler($ctx);
        $node = new UnionTypeNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new UnionTypeNodeHandler($ctx);
        $handler->handleVisit(new UnionTypeNode());

        $this->assertEquals("union { ", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new UnionTypeNodeHandler($ctx);
        $handler->handleLeave(new UnionTypeNode());

        $this->assertEquals(" }", $writer->getBuffer());
    }
}
