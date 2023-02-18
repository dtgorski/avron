<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceParser;
use lengo\avron\api\SourceFile;
use lengo\avron\api\SourceMap;
use lengo\avron\AvroException;

class ProtocolParser implements SourceParser
{
    public function __construct(private readonly StreamParser $streamParser)
    {
    }

    /**
     * @param SourceMap $sourceMap
     * @param SourceFile $sourceFile
     * @throws AvroException
     */
    public function parse(SourceMap $sourceMap, SourceFile $sourceFile): void
    {
        if ($sourceMap->has($sourceFile->getPath())) {
            return;
        }
        if (!$stream = fopen($sourceFile->getPath(), "r")) {
            throw new AvroException(
                sprintf("failed to open file: %s", $sourceFile->getPath())
            );
        }

        try {
            $this->streamParser->parse($sourceMap, $sourceFile, $stream);

        } catch (AvroException $e) {
            throw new AvroException(
                sprintf("%s in file %s\n", $e->getMessage(), $sourceFile->getPath()), 0, $e
            );

        } finally {
            fclose($stream);
        }
    }
}
