<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Api\Visitable;
use Avron\Api\Visitor;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Usage implements Visitor
{
    public function visit(Visitable $node): bool
    {
        // TODO: Implement visit() method.
        return true;
    }

    public function leave(Visitable $node): void
    {
        // TODO: Implement leave() method.
    }
}
