<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\LogicalTypeNode;
use Avron\Ast\LogicalType;

/**
 * @covers \Avron\Idl\LogicalTypeNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\LogicalTypeNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class LogicalTypeNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new LogicalTypeNodeHandler($ctx);
        $node = new LogicalTypeNode(LogicalType::date);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new LogicalTypeNodeHandler($ctx);
        $handler->handleVisit(new LogicalTypeNode(LogicalType::date));

        $this->assertEquals("date", $writer->getBuffer());
    }
}
