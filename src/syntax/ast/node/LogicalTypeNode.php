<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class LogicalTypeNode extends Node
{
    public function __construct(private readonly LogicalType $type)
    {
        parent::__construct();
    }

    public function getType(): LogicalType
    {
        return $this->type;
    }
}
