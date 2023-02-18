<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\ErrorDeclarationNode;

/**
 * @covers \lengo\avron\avdl\ErrorDeclarationNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\ErrorDeclarationNode
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
 */
class ErrorDeclarationNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new ErrorDeclarationNodeHandler($ctx);
        $node = new ErrorDeclarationNode("");

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ErrorDeclarationNodeHandler($ctx);
        $handler->handleVisit(new ErrorDeclarationNode("name"));

        $this->assertEquals("\nerror name {\n", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ErrorDeclarationNodeHandler($ctx);
        $handler->handleLeave(new ErrorDeclarationNode("name"));

        $this->assertEquals("}\n", $writer->getBuffer());
    }
}
