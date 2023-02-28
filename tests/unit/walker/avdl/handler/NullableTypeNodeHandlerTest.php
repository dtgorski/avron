<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\NullableTypeNode;

/**
 * @covers \Avron\AVDL\NullableTypeNodeHandler
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\NullableTypeNode
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\AVDL\TypeNodeHandler
 * @uses   \Avron\BufferedWriter
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
