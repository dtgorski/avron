<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\LogicalTypeNode;
use lengo\avron\ast\LogicalType;

/**
 * @covers \lengo\avron\avdl\LogicalTypeNodeHandler
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\LogicalTypeNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class LogicalTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new LogicalTypeNodeHandler($ctx);
        $node = new LogicalTypeNode(LogicalType::date);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new LogicalTypeNodeHandler($ctx);
        $handler->handleVisit(new LogicalTypeNode(LogicalType::date));

        $this->assertEquals("date", $writer->getBuffer());
    }
}
