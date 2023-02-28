<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\JsonValueNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class JsonValueNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new JsonValueNode("foo");
        $this->assertSame("foo", $type->getValue());
    }

    public function testJsonSerialize(): void
    {
        $type = new JsonValueNode("foo");
        $this->assertSame('"foo"', json_encode($type));
    }
}
