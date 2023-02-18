<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\LogicalTypeNode;

class LogicalTypeNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof LogicalTypeNode;
    }

    public function handleVisit(Visitable|LogicalTypeNode $visitable): bool
    {
        /** @var LogicalTypeNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        $this->writePropertiesSingleLine($visitable->getProperties());
        $this->write($visitable->getType()->name);

        return false;
    }
}