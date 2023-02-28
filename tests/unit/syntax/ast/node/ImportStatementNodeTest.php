<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ImportStatementNode
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\ImportType
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
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
