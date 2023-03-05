<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Cli\Parameters
 * @uses   \Avron\Cli\Command
 * @uses   \Avron\Cli\Operands
 * @uses   \Avron\Cli\Options
 */
class ParametersTest extends TestCase
{
    public function testFromParams()
    {
        $globals = $this->createMock(Options::class);
        $command = $this->createMock(Command::class);
        $operands = $this->createMock(Operands::class);

        $args = Parameters::fromParams($globals, $command, $operands);

        $this->assertSame($globals, $args->getOptions());
        $this->assertSame($command, $args->getCommand());
        $this->assertSame($operands, $args->getOperands());
    }
}
