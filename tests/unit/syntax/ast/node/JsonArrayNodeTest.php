<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\JsonArrayNode
 * @uses   \Avron\Ast\JsonValueNode
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
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
