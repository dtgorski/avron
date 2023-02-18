<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

class StderrWriter extends StandardWriter
{
    public function __construct()
    {
        parent::__construct(STDERR);
    }
}
