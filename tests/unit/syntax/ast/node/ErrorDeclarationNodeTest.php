<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\ErrorDeclarationNode
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Node
 */
class ErrorDeclarationNodeTest extends TestCase
{
    public function testGetName(): void
    {
        $type = new ErrorDeclarationNode("foo");
        $this->assertSame("foo", $type->getName());
    }
}
