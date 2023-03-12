<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\ErrorListNode
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\ErrorType
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\TreeNode
 */
class ErrorListNodeTest extends TestCase
{
    public function testGetType(): void
    {
        $type = new ErrorListNode(ErrorType::oneway);
        $this->assertEquals($type->getType()->name, ErrorType::oneway->name);
    }
}
