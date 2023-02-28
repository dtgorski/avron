<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Core;

use ArrayIterator;
use IteratorAggregate;
use Avron\API\SourceFile;
use Avron\API\SourceMap;
use Avron\API\Visitable;
use Traversable;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 * @template-implements \IteratorAggregate<string,Visitable>
 */
class ProtocolMap implements SourceMap, IteratorAggregate
{
    /** @var array<string,Visitable> */
    private array $map = [];

    public function set(SourceFile $sourceFile, Visitable $visitable): SourceMap
    {
        if (!$this->has($sourceFile->getPath())) {
            $this->map[$sourceFile->getPath()] = $visitable;
        }
        return $this;
    }

    public function has(string $filename): bool
    {
        return array_key_exists($filename, $this->asArray());
    }

    /** @return array<string,Visitable> */
    public function asArray(): array
    {
        return $this->map;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->asArray());
    }
}
