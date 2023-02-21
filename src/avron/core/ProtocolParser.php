<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceFile;
use lengo\avron\api\SourceMap;
use lengo\avron\api\SourceParser;
use lengo\avron\AvronException;

/** @internal This class is not part of the official API. */
class ProtocolParser implements SourceParser
{
    public function __construct(private readonly StreamParser $streamParser)
    {
    }

    /**
     * @param SourceMap $sourceMap
     * @param SourceFile $sourceFile
     * @throws AvronException
     */
    public function parse(SourceMap $sourceMap, SourceFile $sourceFile): void
    {
        $path = $sourceFile->getPath();

        if ($sourceMap->has($path)) {
            return;
        }
        if (!is_readable($path) || is_dir($path)) {
            throw new AvronException(sprintf("unable to read protocol file %s", $path));
        }
        if (!$stream = fopen($path, "r")) {
            throw new AvronException(sprintf("failed to open protocol file: %s", $path));
        }

        try {
            $this->streamParser->parse($sourceMap, $sourceFile, $stream);

        } catch (AvronException $e) {
            throw new AvronException(sprintf("%s in file %s\n", $e->getMessage(), $path), 0, $e);

        } finally {
            fclose($stream);
        }
    }
}
