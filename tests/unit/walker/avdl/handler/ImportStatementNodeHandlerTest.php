<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Ast\ImportStatementNode;
use Avron\Ast\ImportType;

/**
 * @covers \Avron\Idl\ImportStatementNodeHandler
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\ImportStatementNode
 * @uses   \Avron\Ast\ImportType
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\BufferedWriter
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\VisitableNode
 * @uses   \Avron\Idl\HandlerAbstract
 */
class ImportStatementNodeHandlerTest extends HandlerTestCase
{
    public function testCanHandle(): void
    {
        $ctx = $this->createMock(HandlerContext::class);
        $handler = new ImportStatementNodeHandler($ctx);

        $node = new ImportStatementNode(ImportType::idl, "");
        $this->assertTrue($handler->canHandle($node));
    }

    public function testHandleVisit(): void
    {
        list($ctx, $writer) = $this->createContextAndWriter();

        $handler = new ImportStatementNodeHandler($ctx);
        $handler->handleVisit(new ImportStatementNode(ImportType::idl, "name"));

        $this->assertEquals("\nimport idl \"name\";\n", $writer->getBuffer());
    }
}
