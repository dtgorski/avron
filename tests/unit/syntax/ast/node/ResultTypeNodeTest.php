<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ResultTypeNode
 * @uses   \lengo\avron\ast\Node
 */
class ResultTypeNodeTest extends TestCase
{
    public function testIsVoid(): void
    {
        $type = new ResultTypeNode(true);
        $this->assertSame(true, $type->isVoid());
    }
}
