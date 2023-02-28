<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\UnionTypeNode;

/**
 * @covers \Avron\IDL\UnionTypeNodeHandler
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\UnionTypeNode
 * @uses   \Avron\IDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class UnionTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new UnionTypeNodeHandler($ctx);
        $node = new UnionTypeNode();

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new UnionTypeNodeHandler($ctx);
        $handler->handleVisit(new UnionTypeNode());

        $this->assertEquals("union { ", $writer->getBuffer());
    }

    public function testHandleLeave(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new UnionTypeNodeHandler($ctx);
        $handler->handleLeave(new UnionTypeNode());

        $this->assertEquals(" }", $writer->getBuffer());
    }
}
