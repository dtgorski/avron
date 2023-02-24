<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\api\SourceFile;
use lengo\avron\core\NodeNamespace;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
abstract class DeclarationNode extends Node
{
    private ?NodeNamespace $namespace = null;

    private ?SourceFile $sourceFile = null;

    private Comments $comments;

    public function __construct()
    {
        parent::__construct();
        $this->comments = new Comments();
    }

    public function getNamespace(): ?NodeNamespace
    {
        return $this->namespace;
    }

    public function setNamespace(NodeNamespace $namespace): DeclarationNode
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function getSourceFile(): ?SourceFile
    {
        return $this->sourceFile;
    }

    public function setSourceFile(SourceFile $sourceFile): DeclarationNode
    {
        $this->sourceFile = $sourceFile;
        return $this;
    }

    /** @return Comments */
    public function getComments(): Comments
    {
        return $this->comments;
    }

    public function setComments(Comments $comments): DeclarationNode
    {
        $this->comments = $comments;
        return $this;
    }
}
