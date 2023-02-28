<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\IDL;

use Avron\AST\ImportStatementNode;
use Avron\AST\ImportType;

/**
 * @covers \Avron\IDL\ImportStatementNodeHandler
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\ImportStatementNode
 * @uses   \Avron\AST\ImportType
 * @uses   \Avron\AST\Properties
 * @uses   \Avron\AST\Node
 * @uses   \Avron\IDL\HandlerAbstract
 * @uses   \Avron\BufferedWriter
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
