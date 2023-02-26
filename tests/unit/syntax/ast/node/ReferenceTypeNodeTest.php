<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ReferenceTypeNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class ReferenceTypeNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new ReferenceTypeNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
