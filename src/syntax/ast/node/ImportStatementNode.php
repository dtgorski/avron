<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ImportStatementNode extends Node
{
    public function __construct(
        private readonly ImportTypes $type,
        private readonly string $path
    ) {
        parent::__construct();
    }

    public function getType(): ImportTypes
    {
        return $this->type;
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
