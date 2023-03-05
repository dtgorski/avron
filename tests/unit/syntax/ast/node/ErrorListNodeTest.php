<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\ErrorListNode
 * @uses   \Avron\Ast\ErrorType
 * @uses   \Avron\Ast\Node
 * @uses   \Avron\Ast\Properties
 */
class ErrorListNodeTest extends TestCase
{
    public function testGetType(): void
    {
        $type = new ErrorListNode(ErrorType::oneway);
        $this->assertEquals($type->getType()->name, ErrorType::oneway->name);
    }
}
