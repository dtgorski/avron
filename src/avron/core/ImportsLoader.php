<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\core;

use lengo\avron\api\SourceParser;
use lengo\avron\api\SourceMap;
use lengo\avron\api\Visitable;
use lengo\avron\api\Visitor;
use lengo\avron\ast\ImportStatementNode;
use lengo\avron\ast\ImportTypes;
use lengo\avron\AvronException;

/**
 * Follows imports and loads nested protocols.
 *
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ImportsLoader implements Visitor
{
    public function __construct(
        private readonly SourceParser $sourceParser,
        private readonly SourceMap $sourceMap,
        private readonly string $dir
    ) {
    }

    /** @throws AvronException */
    public function visit(Visitable $node): bool
    {
        if (!$node instanceof ImportStatementNode) {
            return true;
        }
        // FIXME: implement protocol and schema imports.
        if ($node->getType() !== ImportTypes::idl) {
            throw new AvronException(sprintf("unsupported import type '%s'", $node->getType()->value));
        }

        $sourceFile = RealPath::fromString(sprintf("%s/%s", $this->dir, $node->getPath()));
        $this->sourceParser->parse($this->sourceMap, $sourceFile);

        return false;
    }

    public function leave(Visitable $node): void
    {
    }
}
