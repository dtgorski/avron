<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\ReferenceTypeNode;

/**
 * @covers \lengo\avron\avdl\ReferenceTypeNodeHandler
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\ReferenceTypeNode
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
