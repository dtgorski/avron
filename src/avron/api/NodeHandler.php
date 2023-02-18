<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

interface NodeHandler
{
    public function canHandle(Visitable $visitable): bool;

    public function handleVisit(Visitable $visitable): bool;

    public function handleLeave(Visitable $visitable): void;
}
