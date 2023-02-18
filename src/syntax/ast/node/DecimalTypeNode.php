<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use InvalidArgumentException;

class DecimalTypeNode extends Node
{
    public function __construct(
        private readonly int $precision,
        private readonly int $scale
    ) {
        parent::__construct();

        if ($precision < 1) {
            throw new InvalidArgumentException("unexpected invalid decimal type precision");
        }
        if ($scale < 0 || $scale > $this->precision) {
            throw new InvalidArgumentException("unexpected invalid decimal type scale");
        }
    }

    public function getPrecision(): int
    {
        return $this->precision;
    }

    public function getScale(): int
    {
        return $this->scale;
    }
}
