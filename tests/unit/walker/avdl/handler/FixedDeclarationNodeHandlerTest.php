<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AVDL;

use Avron\AST\FixedDeclarationNode;

/**
 * @covers \Avron\AVDL\FixedDeclarationNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\FixedDeclarationNode
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AVDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
 */
class FixedDeclarationNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new FixedDeclarationNodeHandler($ctx);
        $node = new FixedDeclarationNode("", 0);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new FixedDeclarationNodeHandler($ctx);
        $handler->handleVisit(new FixedDeclarationNode("foo", 42));

        $this->assertEquals("\nfixed foo(42);\n", $writer->getBuffer());
    }
}
