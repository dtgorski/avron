<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\FormalParameterNode;

/** @internal This class is not part of the official API. */
class FormalParameterNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof FormalParameterNode;
    }

    public function handleVisit(Visitable|FormalParameterNode $visitable): bool
    {
        /** @var FormalParameterNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if ($visitable->getPrevSibling()) {
            $this->write(", ");
        }

        return true;
    }
}
