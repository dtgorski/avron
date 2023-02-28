<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\CLI;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\CLI\Arguments
 * @uses   \Avron\CLI\Command
 * @uses   \Avron\CLI\Operands
 * @uses   \Avron\CLI\Options
 */
class ArgumentsTest extends TestCase
{
    public function testFromParams()
    {
        $globals = $this->createMock(Options::class);
        $command = $this->createMock(Command::class);
        $operands = $this->createMock(Operands::class);

        $args = Arguments::fromParams($globals, $command, $operands);

        $this->assertSame($globals, $args->getGlobals());
        $this->assertSame($command, $args->getCommand());
        $this->assertSame($operands, $args->getOperands());
    }
}
