<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Command
 * @uses   \Avron\Cli\Handler
 * @uses   \Avron\Cli\Options
 */
class CommandTest extends TestCase
{
    public function testFromParams()
    {
        $handler = $this->createMock(Handler::class);
        $options = $this->createMock(Options::class);

        $cmd = Command::fromParams("a", "b", "c", $options, $handler);

        $this->assertEquals("a", $cmd->getName());
        $this->assertEquals("b", $cmd->getUsageArgs());
        $this->assertEquals("c", $cmd->getDescription());
        $this->assertSame($options, $cmd->getOptions());
        $this->assertSame($handler, $cmd->getHandler());
    }
}
