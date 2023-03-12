<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Core\ArrayList;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @extends  ArrayList<Argument>
 */
class Arguments extends ArrayList
{
    /** @param Argument[] $arguments */
    public static function fromArray(array $arguments): Arguments
    {
        return new self($arguments);
    }
}
