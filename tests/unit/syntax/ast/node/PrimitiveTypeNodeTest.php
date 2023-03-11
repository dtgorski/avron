<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\PrimitiveTypeNode
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\VisitableNode
 */
class PrimitiveTypeNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new PrimitiveTypeNode(PrimitiveType::int);
        $this->assertSame("int", $type->getType()->name);
    }
}
