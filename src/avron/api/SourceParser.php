<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\api;

use Exception;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
interface SourceParser
{
    /** @throws Exception  */
    public function parse(SourceMap $sourceMap, SourceFile $sourceFile): void;
}
