<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use JsonSerializable;
use stdClass;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class JsonObjectNode extends AstNode implements JsonSerializable
{
    public function jsonSerialize(): object
    {
        $obj = new stdClass();

        /** @var JsonFieldNode $node */
        foreach ($this->childNodes() as $node) {
            $field = $node->getName();
            $obj->$field = $node->nodeAt(0);
        }

        return $obj;
    }
}
