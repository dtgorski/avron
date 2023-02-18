<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

use Exception;

interface SourceLoader
{
    /** @throws Exception */
    public function load(string ...$filenames): SourceMap;
}
