<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\JsonArrayNode;

/** @internal This class is not part of the official API. */
class JsonArrayNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof JsonArrayNode;
    }

    public function handleVisit(Visitable|JsonArrayNode $visitable): bool
    {
        /** @var JsonArrayNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->getPrevSibling()) {
            $this->write(", ");
        }
        $this->write("[");

        return true;
    }

    public function handleLeave(Visitable|JsonArrayNode $visitable): void
    {
        /** @var JsonArrayNode $visitable calms static analysis down. */
        parent::handleLeave($visitable);

        $this->write("]");
    }
}
