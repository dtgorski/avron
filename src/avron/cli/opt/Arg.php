<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Arg
{
    /**
     * @param string $value
     * @param string|null $preset The value that followed the "=" sign, if any.
     *                    This is required to distinguish between "-x foo" and
     *                    "-x=foo" in case -x must not have an extra argument.
     * @return Arg
     */
    public static function fromOption(string $value, ?string $preset = null): Arg
    {
        return new Arg(ArgType::OPTION, $value, $preset);
    }

    public static function fromOperand(string $value): Arg
    {
        return new Arg(ArgType::OPERAND, $value);
    }

    private function __construct(
        private readonly ArgType $type,
        private readonly string $value,
        private readonly ?string $preset = null
    ) {
    }

    public function isOption(): bool
    {
        return $this->getType() == ArgType::OPTION;
    }

    public function isOperand(): bool
    {
        return $this->getType() == ArgType::OPERAND;
    }

    public function getType(): ArgType
    {
        return $this->type;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getPreset(): ?string
    {
        return $this->preset;
    }
}
