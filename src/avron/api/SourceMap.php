<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

use Traversable;

interface SourceMap
{
    public function set(SourceFile $sourceFile, Visitable $visitable): SourceMap;

    public function has(string $filename): bool;

    public function getIterator(): Traversable;
}
