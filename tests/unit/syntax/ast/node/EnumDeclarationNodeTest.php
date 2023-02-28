<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\EnumDeclarationNode
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 */
class EnumDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new EnumDeclarationNode("foo", "bar");
        $this->assertSame("foo", $type->getName());
    }

    public function testGetDefault(): void
    {
        $type = new EnumDeclarationNode("foo", "bar");
        $this->assertSame("bar", $type->getDefault());
    }
}
