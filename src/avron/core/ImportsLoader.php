<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use Avron\Api\SourceParser;
use Avron\Api\SourceMap;
use Avron\Api\Visitable;
use Avron\Api\Visitor;
use Avron\Ast\ImportStatementNode;
use Avron\Ast\ImportType;
use Avron\AvronException;

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
    public function visit(Visitable $visitable): bool
    {
        if (!$visitable instanceof ImportStatementNode) {
            return true;
        }
        // FIXME: implement protocol and schema imports.
        if ($visitable->getType() !== ImportType::idl) {
            throw new AvronException(
                sprintf("unsupported import type '%s'", $visitable->getType()->value)
            );
        }

        $sourceFile = RealPath::fromString(sprintf("%s/%s", $this->dir, $visitable->getPath()));
        $this->sourceParser->parse($this->sourceMap, $sourceFile);

        return false;
    }

    public function leave(Visitable $visitable): void
    {
    }
}
