<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Ast\JsonValueNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class JsonValueNodeHandler extends HandlerAbstract
{
    public function canHandle(Node $node): bool
    {
        return $node instanceof JsonValueNode;
    }

    public function handleVisit(Node $node): bool
    {
        /** @var JsonValueNode $node calms static analysis down. */
        parent::handleVisit($node);

        if ($node->prevNode()) {
            $this->write(", ");
        }
        $val = $node->getValue();

        switch (true) {
            case is_float($val):
                $this->write($val);
                break;
            case is_string($val):
                $this->write('"', $val, '"');
                break;
            case $val === null:
                $this->write("null");
                break;
            case $val === true:
                $this->write("true");
                break;
            case $val === false:
                $this->write("false");
                break;
        }
        return false;
    }
}
