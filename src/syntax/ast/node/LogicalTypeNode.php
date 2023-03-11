<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
class LogicalTypeNode extends AstNode
{
    public function __construct(
        private readonly LogicalType $type,
        ?Properties $properties = null
    ) {
        parent::__construct($properties);
    }

    public function getType(): LogicalType
    {
        return $this->type;
    }
}
