<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\ErrorListNode
 * @uses   \Avron\AST\ErrorType
 * @uses   \Avron\AST\Node
 * @uses   \Avron\AST\Properties
 */
class ErrorListNodeTest extends TestCase
{
    public function testGetType(): void
    {
        $type = new ErrorListNode(ErrorType::oneway);
        $this->assertEquals($type->getType()->name, ErrorType::oneway->name);
    }
}
