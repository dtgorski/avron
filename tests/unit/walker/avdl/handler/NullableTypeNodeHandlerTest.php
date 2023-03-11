<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\NullableTypeNode;

/**
 * @covers \Avron\Idl\NullableTypeNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\NullableTypeNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Idl\HandlerAbstract
 * @uses   \Avron\Idl\TypeNodeHandler
 */
class NullableTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new NullableTypeNodeHandler($ctx);
        $node = new NullableTypeNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new NullableTypeNodeHandler($ctx);
        $handler->handleLeave(new NullableTypeNode());

        $this->assertEquals("?", $writer->getBuffer());
    }
}
