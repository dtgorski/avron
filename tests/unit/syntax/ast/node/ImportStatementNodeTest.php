<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\ImportStatementNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\ImportType
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\VisitableNode
 */
class ImportStatementNodeTest extends TestCase
{
    public function testGetType(): void
    {
        $type = new ImportStatementNode(ImportType::idl, "foo");
        $this->assertSame(ImportType::idl, $type->getType());
    }

    public function testGetPath(): void
    {
        $type = new ImportStatementNode(ImportType::idl, "foo");
        $this->assertSame("foo", $type->getPath());
    }
}
