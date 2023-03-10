<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\ErrorListNode;
use Avron\Ast\ErrorType;

/**
 * @covers \Avron\Idl\ErrorListNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\ErrorListNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class ErrorListNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        list($ctx) = $this->createContextAndWriter();

        $handler = new ErrorListNodeHandler($ctx);
        $node = new ErrorListNode(ErrorType::throws);

        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ErrorListNodeHandler($ctx);
        $handler->handleVisit(new ErrorListNode(ErrorType::throws));

        $this->assertEquals(" throws ", $writer->getBuffer());
    }
}
