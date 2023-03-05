<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use Avron\Api\SourceFile;
use Avron\AvronException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class RealPath implements SourceFile
{
    /** @throws AvronException */
    public static function fromString(string $sourceFile): SourceFile
    {
        return new RealPath($sourceFile);
    }

    /** @throws AvronException */
    private function __construct(private string $filename)
    {
        if ($realpath = realpath($filename)) {
            $this->filename = $realpath;
            return;
        }
        throw new AvronException(sprintf("unable to read file: %s", $filename));
    }

    public function getPath(): string
    {
        return $this->filename;
    }

    public function getName(): string
    {
        return basename($this->filename);
    }

    public function getDir(): string
    {
        return dirname($this->filename);
    }

    public function __toString(): string
    {
        return $this->getPath();
    }
}
