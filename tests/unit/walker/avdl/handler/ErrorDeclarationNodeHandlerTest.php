<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\ErrorDeclarationNode;

/**
 * @covers \Avron\Idl\ErrorDeclarationNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\ErrorDeclarationNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Idl\HandlerAbstract
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
