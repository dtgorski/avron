<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Api;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
interface NodeHandler
{
    public function canHandle(Node $node): bool;

    public function handleVisit(Node $node): bool;

    public function handleLeave(Node $node): void;
}
