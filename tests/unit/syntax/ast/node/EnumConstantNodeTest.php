<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\EnumConstantNode
 * @uses   \lengo\avron\ast\Node
 */
class EnumConstantNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new EnumConstantNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
