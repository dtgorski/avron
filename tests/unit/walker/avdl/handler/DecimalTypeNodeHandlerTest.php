<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\DecimalTypeNode;

/**
 * @covers \Avron\IDL\DecimalTypeNodeHandler
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\DecimalTypeNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\IDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class DecimalTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new DecimalTypeNodeHandler($ctx);
        $node = new DecimalTypeNode(1, 0);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new DecimalTypeNodeHandler($ctx);
        $handler->handleVisit(new DecimalTypeNode(2, 1));

        $this->assertEquals("decimal(2, 1)", $writer->getBuffer());
    }
}
