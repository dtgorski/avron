<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\cli\Commands
 * @uses   \lengo\avron\cli\Command
 */
class CommandsTest extends TestCase
{
    public function testCommands()
    {
        $handler1 = $this->createMock(Handler::class);
        $options1 = $this->createMock(Options::class);

        $handler2 = $this->createMock(Handler::class);
        $options2 = $this->createMock(Options::class);

        $command1 = Command::fromParams("foo", "bar", $handler1, $options1);
        $command2 = Command::fromParams("baz", "baf", $handler2, $options2);

        $commands = Commands::fromArray([$command1, $command2]);

        $this->assertEquals($command1, $commands->getByName("foo"));
        $this->assertEquals($command2, $commands->getByName("baz"));

        $this->assertSame(null, $commands->getByName(""));
        $this->assertSame(2, $commands->size());

        $this->assertEquals([$command1, $command2], $commands->asArray());
        $this->assertSame($command1, $commands->getIterator()->current());
    }
}
