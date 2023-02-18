<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\NullableTypeNode;

/**
 * @covers \lengo\avron\avdl\NullableTypeNodeHandler
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\NullableTypeNode
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\avdl\TypeNodeHandler
 * @uses   \lengo\avron\BufferedWriter
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
