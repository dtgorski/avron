<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\cli\Command
 * @uses   \lengo\avron\cli\Handler
 * @uses   \lengo\avron\cli\Options
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
