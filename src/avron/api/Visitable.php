<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\api;

/** @internal This interface is not part of the official API. */
interface Visitable
{
    public function accept(Visitor $visitor): void;
}
