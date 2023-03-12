<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\JsonFieldNode
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 */
class JsonFieldNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new JsonFieldNode("foo");
        $this->assertSame("foo", $type->getName());
    }

    public function testJsonSerialize(): void
    {
        $type = new JsonFieldNode("foo");
        $this->assertSame("{}", json_encode($type));
    }
}
