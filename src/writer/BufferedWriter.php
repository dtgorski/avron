<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use lengo\avron\api\Writer;

/** @internal This class is not part of the official API. */
class BufferedWriter implements Writer
{
    /** @var string[] $buffer */
    private array $buffer = [];

    public function write(string|float|int|null ...$args): void
    {
        foreach ($args as $arg) {
            $this->buffer[] = (string)$arg;
        }
    }

    public function clearBuffer(): void
    {
        $this->buffer = [];
    }

    public function getBuffer(): string
    {
        return join("", $this->buffer);
    }
}
