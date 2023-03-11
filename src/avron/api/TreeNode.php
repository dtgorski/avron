<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Api;

use RuntimeException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
interface TreeNode extends Visitable
{
    /** @throws RuntimeException when node already has a parent. */
    public function addNode(TreeNode|null ...$nodes): TreeNode;

    public function parentNode(): TreeNode|null;

    /** @return TreeNode[] */
    public function childNodes(): array;

    public function prevNode(): TreeNode|null;

    public function nextNode(): TreeNode|null;

    public function nodeAt(int $i): TreeNode|null;

    public function nodeIndex(): int;

    public function nodeCount(): int;
}
