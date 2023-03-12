<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\Core\TreeNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
abstract class AstNode extends TreeNode
{
    private Properties $properties;

    public function __construct(Properties $properties = null)
    {
        $this->properties = $properties ?: Properties::fromArray([]);
        parent::__construct();
    }

    public function getProperties(): Properties
    {
        return $this->properties;
    }
}
