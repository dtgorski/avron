<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\ReferenceTypeNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 */
class ReferenceTypeNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new ReferenceTypeNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
