<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

interface Visitor
{
    public function visit(Visitable $node): bool;

    public function leave(Visitable $node): void;
}
