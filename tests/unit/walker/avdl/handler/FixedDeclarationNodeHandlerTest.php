<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\FixedDeclarationNode;

/**
 * @covers \Avron\Idl\FixedDeclarationNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\FixedDeclarationNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
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
