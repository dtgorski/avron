<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/** @internal This class is not part of the official API. */
class FixedDeclarationNode extends DeclarationNode
{
    public function __construct(
        private readonly string $name,
        private readonly int $value
    ) {
        parent::__construct();
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): int
    {
        return $this->value;
    }
}
