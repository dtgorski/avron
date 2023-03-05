<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\LogicalTypeNode
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 */
class LogicalTypeNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new LogicalTypeNode(LogicalType::date);
        $this->assertSame("date", $type->getType()->name);
    }
}
