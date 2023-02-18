<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\JsonObjectNode;

class JsonObjectNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof JsonObjectNode;
    }

    public function handleVisit(Visitable|JsonObjectNode $visitable): bool
    {
        /** @var JsonObjectNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->getPrevSibling()) {
            $this->write(", ");
        }
        $this->write("{");

        return true;
    }

    public function handleLeave(Visitable|JsonObjectNode $visitable): void
    {
        /** @var JsonObjectNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write("}");
    }
}
