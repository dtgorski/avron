<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\ErrorListNode;
use Avron\AST\ErrorType;

/**
 * @covers \Avron\AVDL\ErrorListNodeHandler
 * @uses   \Avron\AST\ErrorListNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class ErrorListNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new ErrorListNodeHandler($ctx);
        $node = new ErrorListNode(ErrorType::throws);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ErrorListNodeHandler($ctx);
        $handler->handleVisit(new ErrorListNode(ErrorType::throws));

        $this->assertEquals(" throws ", $writer->getBuffer());
    }
}
