<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\FixedDeclarationNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\VisitableNode
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
