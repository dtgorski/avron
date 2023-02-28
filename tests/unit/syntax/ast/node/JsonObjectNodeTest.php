<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\JsonObjectNode
 * @uses   \Avron\AST\JsonFieldNode
 * @uses   \Avron\AST\JsonValueNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
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
