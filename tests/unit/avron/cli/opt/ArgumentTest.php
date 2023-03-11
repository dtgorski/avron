<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Argument
 */
class ArgumentTest extends TestCase
{
    public function testFromOption()
    {
        $arg = Argument::fromOption("a", "b");

        $this->assertEquals("a", $arg->getValue());
        $this->assertEquals("b", $arg->getPreset());
        $this->assertEquals(Argument::OPTION, $arg->getType());
        $this->assertTrue($arg->isOption());
        $this->assertFalse($arg->isOperand());
    }

    public function testFromOperand()
    {
        $arg = Argument::fromOperand("a");

        $this->assertEquals("a", $arg->getValue());
        $this->assertEquals(Argument::OPERAND, $arg->getType());
        $this->assertFalse($arg->isOption());
        $this->assertTrue($arg->isOperand());
    }
}
