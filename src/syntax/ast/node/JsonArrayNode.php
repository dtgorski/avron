<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use JsonSerializable;

class JsonArrayNode extends Node implements JsonSerializable
{
    public function jsonSerialize(): array
    {
        return $this->getChildNodes();
    }
}
