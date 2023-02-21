<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

/** @internal This interface is not part of the official API. */
interface Writer
{
    public function write(string|float|int|null ...$args): void;
}
