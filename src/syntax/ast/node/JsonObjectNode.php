<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use JsonSerializable;
use stdClass;

/** @internal This class is not part of the official API. */
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
