<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ErrorListNode
 * @uses   \lengo\avron\ast\ErrorType
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\ast\Properties
 */
class ErrorListNodeTest extends TestCase
{
    public function testGetType(): void
    {
        $type = new ErrorListNode(ErrorType::oneway);
        $this->assertEquals($type->getType()->name, ErrorType::oneway->name);
    }
}
