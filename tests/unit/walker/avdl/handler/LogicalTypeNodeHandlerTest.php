<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\LogicalTypeNode;
use Avron\AST\LogicalType;

/**
 * @covers \Avron\AVDL\LogicalTypeNodeHandler
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\LogicalTypeNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
