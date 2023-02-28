<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\JsonArrayNode
 * @uses   \lengo\avron\ast\JsonValueNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class JsonArrayNodeTest extends TestCase
{
    public function testJsonSerialize(): void
    {
        $type = new JsonArrayNode();

        $type->addNode(new JsonValueNode(true));
        $type->addNode(new JsonValueNode(false));

        $this->assertSame("[true,false]", json_encode($type));
    }
}
