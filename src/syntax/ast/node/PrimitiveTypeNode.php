<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class PrimitiveTypeNode extends Node
{
    public function __construct(private readonly PrimitiveType $type)
    {
        parent::__construct();
    }

    public function getType(): PrimitiveType
    {
        return $this->type;
    }
}
