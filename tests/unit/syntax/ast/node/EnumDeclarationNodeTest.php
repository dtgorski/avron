<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\EnumDeclarationNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
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
