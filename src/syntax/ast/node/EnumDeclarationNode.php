<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class EnumDeclarationNode extends DeclarationNode
{
    public function __construct(
        private readonly string $name,
        private readonly string $default,
        ?Properties $properties = null
    ) {
        parent::__construct($properties);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDefault(): string
    {
        return $this->default;
    }
}
