<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\CLI;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Arguments
{
    /**
     * @param ?Options $globals
     * @param ?Command $command
     * @param ?Operands $operands
     * @return Arguments
     */
    public static function fromParams(
        ?Options $globals,
        ?Command $command,
        ?Operands $operands
    ): Arguments {
        return new Arguments($globals, $command, $operands);
    }

    private function __construct(
        private readonly ?Options $globals,
        private readonly ?Command $command,
        private readonly ?Operands $operands
    ) {
    }

    public function getGlobals(): ?Options
    {
        return $this->globals;
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
