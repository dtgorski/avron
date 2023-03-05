<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\ResultTypeNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 */
class ResultTypeNodeTest extends TestCase
{
    public function testIsVoid(): void
    {
        $type = new ResultTypeNode(true);
        $this->assertSame(true, $type->isVoid());
    }
}
