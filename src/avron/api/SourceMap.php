<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Api;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
interface SourceMap
{
    public function set(SourceFile $sourceFile, Visitable $visitable): SourceMap;

    public function has(string $filename): bool;

    /** @return array<string,Visitable> */
    public function asArray(): array;
}
