<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use JsonSerializable;

class JsonValueNode extends Node implements JsonSerializable
{
    public function __construct(private readonly bool|null|float|string $value)
    {
        parent::__construct();
    }

    public function getValue(): bool|null|float|string
    {
        return $this->value;
    }

    public function jsonSerialize(): bool|null|float|string
    {
        return $this->getValue();
    }
}
