<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\ast\ImportStatementNode;
use lengo\avron\ast\ImportType;

/**
 * @covers \lengo\avron\avdl\ImportStatementNodeHandler
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\ImportStatementNode
 * @uses   \lengo\avron\ast\ImportType
 * @uses   \lengo\avron\ast\Properties
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\avdl\HandlerAbstract
 * @uses   \lengo\avron\BufferedWriter
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
