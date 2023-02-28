<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ProtocolDeclarationNode
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class ProtocolDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new ProtocolDeclarationNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
