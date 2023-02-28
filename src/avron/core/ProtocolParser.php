<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use Avron\API\SourceFile;
use Avron\API\SourceMap;
use Avron\API\SourceParser;
use Avron\AvronException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
