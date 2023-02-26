<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\ErrorListNode;
use lengo\avron\ast\ErrorTypes;

/**
 * @covers \lengo\avron\avdl\ErrorListNodeHandler
 * @uses   \lengo\avron\ast\ErrorListNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class ErrorListNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new ErrorListNodeHandler($ctx);
        $node = new ErrorListNode(ErrorTypes::throws);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ErrorListNodeHandler($ctx);
        $handler->handleVisit(new ErrorListNode(ErrorTypes::throws));

        $this->assertEquals(" throws ", $writer->getBuffer());
    }
}
