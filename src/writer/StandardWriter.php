<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use lengo\avron\api\Writer;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class StandardWriter implements Writer
{
    /** @param resource $stream  */
    public function __construct(private $stream)
    {
    }

    public function write(string|float|int|null ...$args): void
    {
        foreach ($args as $arg) {
            fwrite($this->stream, (string)$arg);
        }
    }
}
