<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\RecordDeclarationNode
 * @uses   \Avron\AST\Comments
 * @uses   \Avron\AST\DeclarationNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 */
class RecordDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new RecordDeclarationNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
