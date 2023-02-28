<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use JsonSerializable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
