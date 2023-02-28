<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\JsonFieldNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
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
