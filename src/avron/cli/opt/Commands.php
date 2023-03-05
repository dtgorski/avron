<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Cli;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @template-implements \IteratorAggregate<int,Command>
 */
class Commands implements IteratorAggregate
{
    /** @param Command[] $commands */
    public static function fromArray(array $commands): Commands
    {
        return new Commands($commands);
    }

    /** @param Command[] $commands */
    private function __construct(private readonly array $commands)
    {
    }

    public function getByName(string $name): ?Command
    {
        foreach ($this->asArray() as $cmd) {
            if ($name === $cmd->getName()) {
                return $cmd;
            }
        }
        return null;
    }

    /** @return Command[] */
    public function asArray(): array
    {
        return $this->commands;
    }

    public function size(): int
    {
        return sizeof($this->asArray());
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->asArray());
    }
}
