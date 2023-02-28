<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\ImportStatementNode
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\ImportType
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
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
