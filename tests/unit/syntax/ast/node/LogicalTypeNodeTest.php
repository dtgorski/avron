<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\LogicalTypeNode
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class LogicalTypeNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new LogicalTypeNode(LogicalType::date);
        $this->assertSame("date", $type->getType()->name);
    }
}
