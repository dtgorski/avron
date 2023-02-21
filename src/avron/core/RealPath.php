<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceFile;
use lengo\avron\AvronException;

/** @internal This class is not part of the official API. */
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
