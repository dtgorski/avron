<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\ResultTypeNode
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 */
class ResultTypeNodeTest extends TestCase
{
    public function testIsVoid(): void
    {
        $type = new ResultTypeNode(true);
        $this->assertSame(true, $type->isVoid());
    }
}
