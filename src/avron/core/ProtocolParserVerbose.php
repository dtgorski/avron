<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceFile;
use lengo\avron\api\SourceMap;
use lengo\avron\api\SourceParser;
use lengo\avron\AvroException;
use lengo\avron\Logger;

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
     * @throws AvroException
     */
    public function parse(SourceMap $sourceMap, SourceFile $sourceFile): void
    {
        $this->logger->info(sprintf("reading protocol file: %s", $sourceFile->getPath()));
        $this->protocolParser->parse($sourceMap, $sourceFile);
    }
}
