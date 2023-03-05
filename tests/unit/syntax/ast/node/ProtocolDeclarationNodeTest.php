<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\ProtocolDeclarationNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 */
class ProtocolDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new ProtocolDeclarationNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
