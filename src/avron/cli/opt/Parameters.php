<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Parameters
{
    /**
     * @param ?Options $options
     * @param ?Command $command
     * @param ?Operands $operands
     * @return Parameters
     */
    public static function fromParams(
        ?Options $options,
        ?Command $command,
        ?Operands $operands
    ): Parameters {
        return new Parameters($options, $command, $operands);
    }

    private function __construct(
        private readonly ?Options $options,
        private readonly ?Command $command,
        private readonly ?Operands $operands
    ) {
    }

    public function getOptions(): ?Options
    {
        return $this->options;
    }

    public function getCommand(): ?Command
    {
        return $this->command;
    }

    public function getOperands(): ?Operands
    {
        return $this->operands;
    }
}
