<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

use Exception;

interface SourceParser
{
    /** @throws Exception  */
    public function parse(SourceMap $sourceMap, SourceFile $sourceFile): void;
}
