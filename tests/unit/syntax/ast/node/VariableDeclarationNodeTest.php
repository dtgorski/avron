<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\VariableDeclaratorNode
 * @uses   \lengo\avron\ast\Node
 */
class VariableDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new VariableDeclaratorNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
