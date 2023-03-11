<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Classifier
 * @uses   \Avron\Cli\Argument
 * @uses   \Avron\Cli\Arguments
 * @uses   \Avron\Core\ArrayList
 */
class ClassifierTest extends TestCase
{
    public function testWithoutArguments()
    {
        $args = Classifier::parseArguments([]);
        $this->assertSame(0, $args->size());
    }

    /** @dataProvider provideArguments */
    public function testBasicArguments(array $arguments, callable $test)
    {
        $test(Classifier::parseArguments($arguments));
    }

    public function provideArguments(): array
    {
        $at = function (Arguments $args, int $index): Argument {
            return $args->asArray()[$index];
        };

        /** @var Arguments $args */
        return [
            [[] /*          */, fn($args) => $this->assertSame(0, $args->size())],
            [[""] /*        */, fn($args) => $this->assertSame(0, $args->size())],
            [["", ""] /*    */, fn($args) => $this->assertSame(0, $args->size())],
            [["--"] /*      */, fn($args) => $this->assertSame(0, $args->size())],

            [["x"] /*       */, fn($args) => $this->assertEquals("x", $at($args, 0)->getValue())],
            [["x"] /*       */, fn($args) => $this->assertSame(true, $at($args, 0)->isOperand())],
            [["x"] /*       */, fn($args) => $this->assertSame(null, ($at($args, 0)->getPreset()))],

            [["x="] /*      */, fn($args) => $this->assertEquals("x=", $at($args, 0)->getValue())],
            [["x="] /*      */, fn($args) => $this->assertSame(true, $at($args, 0)->isOperand())],
            [["x="] /*      */, fn($args) => $this->assertSame(null, $at($args, 0)->getPreset())],

            [["x", "y"] /*  */, fn($args) => $this->assertEquals("x", $at($args, 0)->getValue())],
            [["x", "y"] /*  */, fn($args) => $this->assertSame(true, $at($args, 0)->isOperand())],
            [["x", "y"] /*  */, fn($args) => $this->assertSame(null, $at($args, 0)->getPreset())],

            [["x", "y"] /*  */, fn($args) => $this->assertEquals("y", $at($args, 1)->getValue())],
            [["x", "y"] /*  */, fn($args) => $this->assertSame(true, $at($args, 1)->isOperand())],
            [["x", "y"] /*  */, fn($args) => $this->assertSame(null, $at($args, 1)->getPreset())],

            [["--", "-x"] /**/, fn($args) => $this->assertEquals("-x", $at($args, 0)->getValue())],
            [["--", "-x"] /**/, fn($args) => $this->assertSame(true, $at($args, 0)->isOperand())],
            [["--", "-x"] /**/, fn($args) => $this->assertSame(null, ($at($args, 0)->getPreset()))],

            [["-x"] /*      */, fn($args) => $this->assertEquals("x", $at($args, 0)->getValue())],
            [["-x"] /*      */, fn($args) => $this->assertSame(true, $at($args, 0)->isOption())],
            [["-x"] /*      */, fn($args) => $this->assertSame(null, $at($args, 0)->getPreset())],

            [["-x="] /*     */, fn($args) => $this->assertEquals("x", $at($args, 0)->getValue())],
            [["-x="] /*     */, fn($args) => $this->assertSame(true, $at($args, 0)->isOption())],
            [["-x="] /*     */, fn($args) => $this->assertEquals("", $at($args, 0)->getPreset())],

            [["-x=y"] /*    */, fn($args) => $this->assertEquals("x", $at($args, 0)->getValue())],
            [["-x=y"] /*    */, fn($args) => $this->assertSame(true, $at($args, 0)->isOption())],
            [["-x=y"] /*    */, fn($args) => $this->assertEquals("y", $at($args, 0)->getPreset())],

            [["-xx=y"] /*   */, fn($args) => $this->assertEquals("x", $at($args, 0)->getValue())],
            [["-xx=y"] /*   */, fn($args) => $this->assertSame(true, $at($args, 0)->isOption())],
            [["-xx=y"] /*   */, fn($args) => $this->assertEquals(null, $at($args, 0)->getPreset())],
            [["-xx=y"] /*   */, fn($args) => $this->assertEquals("x", $at($args, 1)->getValue())],
            [["-xx=y"] /*   */, fn($args) => $this->assertSame(true, $at($args, 1)->isOption())],
            [["-xx=y"] /*   */, fn($args) => $this->assertEquals("y", $at($args, 1)->getPreset())],

            [["-x", "y"] /* */, fn($args) => $this->assertEquals("x", $at($args, 0)->getValue())],
            [["-x", "y"] /* */, fn($args) => $this->assertSame(true, $at($args, 0)->isOption())],
            [["-x", "y"] /* */, fn($args) => $this->assertSame(null, $at($args, 0)->getPreset())],
            [["-x", "y"] /* */, fn($args) => $this->assertEquals("y", $at($args, 1)->getValue())],
            [["-x", "y"] /* */, fn($args) => $this->assertSame(true, $at($args, 1)->isOperand())],
        ];
    }
}
