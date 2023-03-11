<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use JsonSerializable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class JsonArrayNode extends AstNode implements JsonSerializable
{
    public function jsonSerialize(): array
    {
        return $this->childNodes();
    }
}
