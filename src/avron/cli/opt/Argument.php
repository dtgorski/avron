<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Argument
{
    public const OPTION = "option";
    public const OPERAND = "operand";

    /**
     * @param string $value
     * @param string|null $preset The value that followed the "=" sign, if any.
     *                    This is required to distinguish between "-x foo" and
     *                    "-x=foo" in case -x must not have an extra argument.
     * @return Argument
     */
    public static function fromOption(string $value, ?string $preset = null): Argument
    {
        return new Argument(self::OPTION, $value, $preset);
    }

    public static function fromOperand(string $value): Argument
    {
        return new Argument(self::OPERAND, $value);
    }

    private function __construct(
        private readonly string $type,
        private readonly string $value,
        private readonly ?string $preset = null
    ) {
    }

    public function isOption(): bool
    {
        return $this->getType() == self::OPTION;
    }

    public function isOperand(): bool
    {
        return $this->getType() == self::OPERAND;
    }

    public function getType(): string
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
