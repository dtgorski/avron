<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
interface SourceMap
{
    public function set(SourceFile $sourceFile, Visitable $visitable): SourceMap;

    public function has(string $filename): bool;

    /** @return array<SourceFile,Visitable> */
    public function asArray(): array;
}
