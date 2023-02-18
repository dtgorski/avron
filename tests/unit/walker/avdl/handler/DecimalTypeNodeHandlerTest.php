<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\DecimalTypeNode;

/**
 * @covers \lengo\avron\avdl\DecimalTypeNodeHandler
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\DecimalTypeNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class DecimalTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new DecimalTypeNodeHandler($ctx);
        $node = new DecimalTypeNode(1, 0);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new DecimalTypeNodeHandler($ctx);
        $handler->handleVisit(new DecimalTypeNode(2, 1));

        $this->assertEquals("decimal(2, 1)", $writer->getBuffer());
    }
}
