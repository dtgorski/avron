<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Option
 */
class OptionTest extends TestCase
{
    public function testDefaultOption()
    {
        $option = Option::fromMap([]);

        $this->assertEquals("", $option->get(Option::OPT_SHORT));
        $this->assertEquals("", $option->get(Option::OPT_LONG));
        $this->assertEquals("", $option->get(Option::OPT_DESC));

        $this->assertEquals("ARG_NONE", $option->get(Option::OPT_MODE));
        $this->assertEquals("args", $option->get(Option::OPT_ARGN));
        $this->assertEquals("", $option->get(Option::OPT_VALUE));
    }

    public function testExistingOption()
    {
        $option = Option::fromMap([
            Option::OPT_SHORT => "f",
            Option::OPT_LONG => "foo",
            Option::OPT_DESC => "bar",
            Option::OPT_MODE => Option::MODE_ARG_SINGLE,
            Option::OPT_ARGN => "file",
        ]);

        $option = Option::fromOption($option, [
            Option::OPT_VALUE => "value",
        ]);

        $this->assertEquals("f", $option->get(Option::OPT_SHORT));
        $this->assertEquals("foo", $option->get(Option::OPT_LONG));
        $this->assertEquals("bar", $option->get(Option::OPT_DESC));

        $this->assertEquals("ARG_SINGLE", $option->get(Option::OPT_MODE));
        $this->assertEquals("file", $option->get(Option::OPT_ARGN));
        $this->assertEquals("value", $option->get(Option::OPT_VALUE));
    }

    public function testNumberOfKeysTested()
    {
        $class = new \ReflectionClass(Option::class);

        $opts = 0;
        $args = 0;
        foreach ($class->getConstants() as $const) {
            !str_starts_with($const, "OPT_") ?: $opts++;
            !str_starts_with($const, "ARG_") ?: $args++;
        }
        $this->assertEquals(6, $opts);
        $this->assertEquals(3, $args);
    }
}
