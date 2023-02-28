<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\JsonArrayNode
 * @uses   \Avron\AST\JsonValueNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
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
