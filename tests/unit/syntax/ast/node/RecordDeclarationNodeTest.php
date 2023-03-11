<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\RecordDeclarationNode
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\DeclarationNode
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\VisitableNode
 */
class RecordDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new RecordDeclarationNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
