<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use lengo\avron\api\Writer;

/** @internal This class is not part of the official API. */
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
