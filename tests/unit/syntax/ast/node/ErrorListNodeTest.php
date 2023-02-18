<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ErrorListNode
 * @uses   \lengo\avron\ast\ErrorTypes
 * @uses   \lengo\avron\ast\Node
 */
class ErrorListNodeTest extends TestCase
{
    public function testGetType(): void
    {
        $type = new ErrorListNode(ErrorTypes::oneway);
        $this->assertEquals($type->getType()->name, ErrorTypes::oneway->name);
    }
}
