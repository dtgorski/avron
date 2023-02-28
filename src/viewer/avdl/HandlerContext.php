<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\api\Writer;
use RuntimeException;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
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
