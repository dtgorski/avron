<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\api\SourceFile;
use lengo\avron\core\NodeNamespace;

abstract class DeclarationNode extends Node
{
    private NodeNamespace|null $namespace = null;

    private SourceFile|null $sourceFile = null;

    private Comments $comments;

    public function __construct()
    {
        parent::__construct();
        $this->comments = new Comments();
    }

    public function getNamespace(): NodeNamespace|null
    {
        return $this->namespace;
    }

    public function setNamespace(NodeNamespace|null $namespace): Node
    {
        $this->namespace = $namespace;
        return $this;
    }

    public function getSourceFile(): SourceFile|null
    {
        return $this->sourceFile;
    }

    public function setSourceFile(SourceFile $sourceFile): Node
    {
        $this->sourceFile = $sourceFile;
        return $this;
    }

    /** @return Comments */
    public function getComments(): Comments
    {
        return $this->comments;
    }

    public function setComments(Comments $comments): Node
    {
        $this->comments = $comments;
        return $this;
    }
}
