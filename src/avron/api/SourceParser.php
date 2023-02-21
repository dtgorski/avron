<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

use Exception;

/** @internal This interface is not part of the official API. */
interface SourceParser
{
    /** @throws Exception  */
    public function parse(SourceMap $sourceMap, SourceFile $sourceFile): void;
}
