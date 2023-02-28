<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\MessageDeclarationNode
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class MessageDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new MessageDeclarationNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
