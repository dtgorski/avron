<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\api;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
interface Writer
{
    public function write(string|float|int|null ...$args): void;
}
