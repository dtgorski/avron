<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use JsonSerializable;
use stdClass;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class JsonObjectNode extends Node implements JsonSerializable
{
    public function jsonSerialize(): object
    {
        $obj = new stdClass();

        /** @var JsonFieldNode $node */
        foreach ($this->getChildNodes() as $node) {
            $field = $node->getName();
            $obj->$field = $node->getChildNodeAt(0);
        }

        return $obj;
    }
}
