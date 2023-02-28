<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\cli;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Operands
{
    /** @param string[] $operands */
    public static function fromArray(array $operands): Operands
    {
        return new Operands($operands);
    }

    /** @param string[] $operands */
    private function __construct(private readonly array $operands)
    {
    }

    /** @return string[] */
    public function asArray(): array
    {
        return $this->operands;
    }

    public function size(): int
    {
        return sizeof($this->asArray());
    }
}
