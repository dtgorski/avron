<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\JsonValueNode;

class JSONValueNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof JsonValueNode;
    }

    public function handleVisit(Visitable|JsonValueNode $visitable): bool
    {
        /** @var JsonValueNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->getPrevSibling()) {
            $this->write(", ");
        }
        $val = $visitable->getValue();

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
