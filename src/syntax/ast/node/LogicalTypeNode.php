<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/** @internal This class is not part of the official API. */
class LogicalTypeNode extends Node
{
    public function __construct(private readonly LogicalTypes $type)
    {
        parent::__construct();
    }

    public function getType(): LogicalTypes
    {
        return $this->type;
    }
}
