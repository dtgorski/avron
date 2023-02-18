<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

class PrimitiveTypeNode extends Node
{
    public function __construct(private readonly PrimitiveTypes $type)
    {
        parent::__construct();
    }

    public function getType(): PrimitiveTypes
    {
        return $this->type;
    }
}
