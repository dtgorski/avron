<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\JsonObjectNode
 * @uses   \Avron\Ast\JsonFieldNode
 * @uses   \Avron\Ast\JsonValueNode
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 */
class JsonObjectNodeTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $type = new JsonObjectNode();

        $type->addNode((new JsonFieldNode("foo"))->addNode(new JsonValueNode(true)));
        $type->addNode((new JsonFieldNode("bar"))->addNode(new JsonValueNode(false)));

        $this->assertSame('{"foo":true,"bar":false}', json_encode($type));
    }
}
