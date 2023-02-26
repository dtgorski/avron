<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceFile;
use lengo\avron\api\SourceMap;
use lengo\avron\api\Visitable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ProtocolMap implements SourceMap
{
    /** @var array<SourceFile,Visitable> $map */
    private array $map = [];

    public function set(SourceFile $sourceFile, Visitable $visitable): SourceMap
    {
        if (!$this->has($sourceFile->getPath())) {
            $this->map[$sourceFile->getPath()] = $visitable;
        }
        return $this;
    }

    public function has(string $filename): bool
    {
        return array_key_exists($filename, $this->map);
    }

    public function asArray(): array
    {
        return $this->map;
    }
}
