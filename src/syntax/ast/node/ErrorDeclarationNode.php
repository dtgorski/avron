<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class ErrorDeclarationNode extends DeclarationNode
{
    public function __construct(private readonly string $name)
    {
        parent::__construct();
    }

    public function getName(): string
    {
        return $this->name;
    }
}
