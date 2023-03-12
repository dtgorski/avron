<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Core\ArrayList;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @extends  ArrayList<string>
 */
class Operands extends ArrayList
{
    /** @param string[] $operands */
    public static function fromArray(array $operands): Operands
    {
        return new self($operands);
    }
}
