<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\FixedDeclarationNode
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class FixedDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new FixedDeclarationNode("foo", 42);
        $this->assertSame("foo", $type->getName());
    }

    public function testGetValue(): void
    {
        $type = new FixedDeclarationNode("foo", 42);
        $this->assertSame(42, $type->getValue());
    }
}
