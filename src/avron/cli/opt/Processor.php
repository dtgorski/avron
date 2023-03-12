<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use Avron\Api\Visitable;
use Avron\Api\Visitor;
use Exception;
use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class Processor implements Visitor
{
    private Traversable $it;

    public function __construct(private readonly Arguments $arguments)
    {
    }

    /**
     * @param Command $handler Handler tree reflecting the command hierarchy.
     * @throws Exception
     */
    public function process(Command $handler): void
    {
        $this->it = $this->arguments->getIterator();
        $handler->accept($this);
    }

    public function visit(Visitable $visitable): bool
    {
        if (!$visitable instanceof Command) {
            return true;
        }
        $options = $visitable->options();

        echo "enter  ", get_class($visitable), "\n";
        return true;
    }

    public function leave(Visitable $visitable): void
    {
        if (!$visitable instanceof Command) {
            return;
        }
        echo "leave ", get_class($visitable), "\n";
    }
}
