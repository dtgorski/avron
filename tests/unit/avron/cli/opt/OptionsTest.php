<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Options
 * @uses   \Avron\Cli\Option
 */
class OptionsTest extends TestCase
{
    public function testOptions()
    {
        $option1 = Option::fromMap([
            Option::OPT_SHORT => "f",
            Option::OPT_LONG => "foo",
        ]);
        $option2 = Option::fromMap([
            Option::OPT_SHORT => "b",
            Option::OPT_LONG => "bar",
        ]);

        $options = Options::fromArray([$option1, $option2]);

        $this->assertSame(null, $options->getByName("baz"));
        $this->assertSame($option1, $options->getByName("f"));
        $this->assertSame($option1, $options->getByName("foo"));
        $this->assertSame($option2, $options->getByName("b"));
        $this->assertSame($option2, $options->getByName("bar"));

        $this->assertSame(2, $options->size());
        $this->assertEquals([$option1, $option2], $options->asArray());
        $this->assertSame($option1, $options->getIterator()->current());
    }
}
