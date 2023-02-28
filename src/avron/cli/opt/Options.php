<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\cli;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @template-implements \IteratorAggregate<Option>
 */
class Options implements IteratorAggregate
{
    /** @param Option[] $options */
    public static function fromArray(array $options): Options
    {
        // TODO: check uniqueness of short & long options
        // TODO: merge multiarg options to array value
        return new Options($options);
    }

    /** @param Option[] $options */
    private function __construct(private readonly array $options)
    {
    }

    public function getByName(string $name): ?Option
    {
        foreach ($this->options as $opt) {
            if ($name === $opt->get(Option::OPT_SHORT)) {
                return $opt;
            }
            if ($name === $opt->get(Option::OPT_LONG)) {
                return $opt;
            }
        }
        return null;
    }

    /** @return Option[] */
    public function asArray(): array
    {
        return $this->options;
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
