<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

class JsonFieldNode extends Node
{
    public function __construct(private readonly string $name)
    {
        parent::__construct();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
