<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Arguments
 * @uses   \Avron\Cli\Argument
 * @uses   \Avron\Core\ArrayList
 */
class ArgumentsTest extends TestCase
{
    public function testArguments()
    {
        $arg1 = Argument::fromOption("");
        $arg2 = Argument::fromOption("");

        $arguments = Arguments::fromArray([$arg1, $arg2]);

        $this->assertSame(2, $arguments->size());
        $this->assertEquals([$arg1, $arg2], $arguments->asArray());
        $this->assertSame($arg1, $arguments->getIterator()->current());
    }
}
