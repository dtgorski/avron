<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\PrimitiveTypeNode;
use lengo\avron\ast\PrimitiveTypes;

/**
 * @covers \lengo\avron\avdl\PrimitiveTypeNodeHandler
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\PrimitiveTypeNode
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class PrimitiveTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new PrimitiveTypeNodeHandler($ctx);
        $node = new PrimitiveTypeNode(PrimitiveTypes::int);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new PrimitiveTypeNodeHandler($ctx);
        $handler->handleVisit(new PrimitiveTypeNode(PrimitiveTypes::int));

        $this->assertEquals("int", $writer->getBuffer());
    }
}
