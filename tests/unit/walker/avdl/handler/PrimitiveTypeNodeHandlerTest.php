<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\PrimitiveTypeNode;
use Avron\Ast\PrimitiveType;

/**
 * @covers \Avron\Idl\PrimitiveTypeNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\PrimitiveTypeNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class PrimitiveTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new PrimitiveTypeNodeHandler($ctx);
        $node = new PrimitiveTypeNode(PrimitiveType::int);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new PrimitiveTypeNodeHandler($ctx);
        $handler->handleVisit(new PrimitiveTypeNode(PrimitiveType::int));

        $this->assertEquals("int", $writer->getBuffer());
    }
}
