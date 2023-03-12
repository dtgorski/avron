<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Api;

use RuntimeException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
interface Node extends Visitable
{
    /** @throws RuntimeException when node already has a parent. */
    public function addNode(Node|null ...$nodes): Node;

    public function parentNode(): Node|null;

    /** @return Node[] */
    public function childNodes(): array;

    public function prevNode(): Node|null;

    public function nextNode(): Node|null;

    public function nodeAt(int $i): Node|null;

    public function nodeIndex(): int;

    public function nodeCount(): int;
}
