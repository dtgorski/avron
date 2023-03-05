<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Operands
 */
class OperandsTest extends TestCase
{
    public function testOperands()
    {
        $operand1 = "foo";
        $operand2 = "bar";

        $operands = Operands::fromArray([$operand1, $operand2]);

        $this->assertSame(2, $operands->size());
        $this->assertEquals([$operand1, $operand2], $operands->asArray());
    }
}
