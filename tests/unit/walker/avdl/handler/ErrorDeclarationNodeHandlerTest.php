<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\ErrorDeclarationNode;

/**
 * @covers \Avron\AVDL\ErrorDeclarationNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\ErrorDeclarationNode
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
