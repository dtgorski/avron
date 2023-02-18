<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Visitable;
use lengo\avron\ast\ImportStatementNode;

class ImportStatementNodeHandler extends HandlerAbstract
{
    public function canHandle(Visitable $visitable): bool
    {
        return $visitable instanceof ImportStatementNode;
    }

    public function handleVisit(Visitable|ImportStatementNode $visitable): bool
    {
        /** @var ImportStatementNode $visitable calms static analysis down. */
        parent::handleVisit($visitable);

        if (!$visitable->getPrevSibling() instanceof ImportStatementNode) {
            $this->write("\n");
        }

        $name = $visitable->getType()->value;
        $path = $visitable->getPath();
        $this->write($this->indent(), "import ", $name, " \"", $path, "\";\n");

        return false;
    }
}
