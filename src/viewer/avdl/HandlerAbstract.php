<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\avdl;

use lengo\avron\api\NodeHandler;
use lengo\avron\api\Visitable;
use lengo\avron\ast\Comment;
use lengo\avron\ast\Comments;
use lengo\avron\ast\DeclarationNode;
use lengo\avron\ast\FieldDeclarationNode;
use lengo\avron\ast\Properties;
use lengo\avron\ast\ProtocolDeclarationNode;

/**
 * @internal This declaration is internal and is NOT PART of any official API.
 *           Semantic versioning consent does not apply here. Use at own risk.
 */
abstract class HandlerAbstract implements NodeHandler
{
    public function __construct(private readonly HandlerContext $context)
    {
    }

    /**
     * Writes out:
     *  - The documentation block for Declaration nodes
     *  - The schema properties block for Declaration nodes
     * Does not write out:
     *  - Inline schema properties
     *
     * @param Visitable|DeclarationNode $visitable
     * @return bool
     */
    public function handleVisit(Visitable|DeclarationNode $visitable): bool
    {
        if (!$visitable instanceof DeclarationNode) {
            return true;
        }

        $isProtoNode = $visitable instanceof ProtocolDeclarationNode;
        $isFieldNode = $visitable instanceof FieldDeclarationNode;
        $hasComments = $visitable->getComments()->size() > 0;
        $hasProperties = $visitable->getProperties()->size() > 0;

        if (!$isFieldNode || $hasComments || $hasProperties) {
            $this->write($isProtoNode ? "" : "\n");
        }

        $this->writeComments($visitable->getComments());
        $this->writePropertiesMultiLine($visitable->getProperties());

        return true;
    }

    public function handleLeave(Visitable|DeclarationNode $visitable): void
    {
    }

    protected function write(string|float|int|null ...$args): void
    {
        $this->context->getWriter()->write(...$args);
    }

    protected function writeComments(Comments $comments): void
    {
        foreach ($comments as $comment) {
            $this->writeComment($comment);
        }
    }

    protected function writeComment(Comment $comment): void
    {
        if (strpos($comment->getText(), "\n")) {
            $this->writeCommentMultiLine($comment);
        } else {
            $this->writeCommentSingleLine($comment);
        }
    }

    protected function writeCommentMultiLine(Comment $comment): void
    {
        $this->write($this->indent(), "/**\n");
        foreach (explode("\n", $comment->getText()) as $line) {
            $this->write($this->indent(), " * ", $line, "\n");
        }
        $this->write($this->indent(), " */\n");
    }

    protected function indent(): string
    {
        return str_repeat("\t", $this->context->getStep());
    }

    protected function writeCommentSingleLine(Comment $comment): void
    {
        $this->write($this->indent(), "/** ", $comment->getText(), " */\n");
    }

    protected function writePropertiesMultiLine(Properties $props): void
    {
        foreach ($props as $prop) {
            $this->write($this->indent(), "@", $prop->getName(), "(", json_encode($prop->getValue()), ")\n");
        }
    }

    protected function writePropertiesSingleLine(Properties $props): void
    {
        foreach ($props as $prop) {
            $this->write("@", $prop->getName(), "(", json_encode($prop->getValue()), ") ");
        }
    }

    protected function stepIn(): void
    {
        $this->context->stepIn();
    }

    protected function stepOut(): void
    {
        $this->context->stepOut();
    }
}
