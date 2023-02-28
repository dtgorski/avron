<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\JsonObjectNode
 * @uses   \lengo\avron\ast\JsonFieldNode
 * @uses   \lengo\avron\ast\JsonValueNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
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
