<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\PrimitiveTypeNode
 * @uses   \lengo\avron\ast\Node
 */
class PrimitiveTypeNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new PrimitiveTypeNode(PrimitiveTypes::int);
        $this->assertSame("int", $type->getType()->name);
    }
}
