<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

interface Writer
{
    public function write(string|float|int|null ...$args): void;
}
