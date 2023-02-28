<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\CLI;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\CLI\Command
 * @uses   \Avron\CLI\Handler
 * @uses   \Avron\CLI\Options
 */
class CommandTest extends TestCase
{
    public function testFromParams()
    {
        $handler = $this->createMock(Handler::class);
        $options = $this->createMock(Options::class);

        $cmd = Command::fromParams("a", "b", $handler, $options);

        $this->assertEquals("a", $cmd->getName());
        $this->assertEquals("b", $cmd->getDescription());
        $this->assertSame($handler, $cmd->getHandler());
        $this->assertSame($options, $cmd->getOptions());
    }
}
