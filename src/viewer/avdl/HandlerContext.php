<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Writer;
use RuntimeException;

class HandlerContext
{
    private int $step = 0;

    public function __construct(private readonly Writer $writer)
    {
    }

    public function getWriter(): Writer
    {
        return $this->writer;
    }

    public function stepIn(): void
    {
        $this->step++;
    }

    public function stepOut(): void
    {
        if (--$this->step < 0) {
            throw new RuntimeException("step underrun");
        }
    }

    public function getStep(): int
    {
        return $this->step;
    }
}
