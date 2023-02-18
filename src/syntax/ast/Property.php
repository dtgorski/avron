<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

class Property implements \JsonSerializable
{
    public function __construct(
        private readonly string $name,
        private readonly mixed $value
    ) {
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function jsonSerialize(): array
    {
        return [
            $this->getName() => $this->getValue()
        ];
    }
}
