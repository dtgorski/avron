<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\cli\Arg
 */
class ArgTest extends TestCase
{
    public function testArg()
    {
        $arg1 = Arg::fromOption("foo", "bar");

        $this->assertEquals("foo", $arg1->getValue());
        $this->assertEquals("bar", $arg1->getPreset());
        $this->assertEquals(ArgType::OPTION, $arg1->getType());
        $this->assertTrue($arg1->isOption());
        $this->assertFalse($arg1->isOperand());

        $arg2 = Arg::fromOperand("baz");

        $this->assertEquals("baz", $arg2->getValue());
        $this->assertEquals(ArgType::OPERAND, $arg2->getType());
        $this->assertFalse($arg2->isOption());
        $this->assertTrue($arg2->isOperand());
    }
}
