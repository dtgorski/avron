<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\VariableDeclaratorNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 */
class VariableDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new VariableDeclaratorNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
