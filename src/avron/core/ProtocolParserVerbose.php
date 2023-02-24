<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceFile;
use lengo\avron\api\SourceMap;
use lengo\avron\api\SourceParser;
use lengo\avron\AvronException;
use lengo\avron\Logger;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ProtocolParserVerbose implements SourceParser
{
    public function __construct(
        private readonly ProtocolParser $protocolParser,
        private readonly Logger $logger,
    ) {
    }

    /**
     * @param SourceMap $sourceMap
     * @param SourceFile $sourceFile
     * @throws AvronException
     */
    public function parse(SourceMap $sourceMap, SourceFile $sourceFile): void
    {
        $this->logger->info("reading protocol file: ", $sourceFile->getPath());
        $this->protocolParser->parse($sourceMap, $sourceFile);
    }
}
