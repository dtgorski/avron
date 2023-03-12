<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\Api\Node;
use Avron\Api\NodeHandler;
use Avron\Ast\Comment;
use Avron\Ast\Comments;
use Avron\Ast\DeclarationNode;
use Avron\Ast\FieldDeclarationNode;
use Avron\Ast\Properties;
use Avron\Ast\ProtocolDeclarationNode;

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
     * @param Node $node
     * @return bool
     */
    public function handleVisit(Node $node): bool
    {
        if (!$node instanceof DeclarationNode) {
            return true;
        }

        $isProtoNode = $node instanceof ProtocolDeclarationNode;
        $isFieldNode = $node instanceof FieldDeclarationNode;
        $hasComments = $node->getComments()->size() > 0;
        $hasProperties = $node->getProperties()->size() > 0;

        if (!$isFieldNode || $hasComments || $hasProperties) {
            $this->write($isProtoNode ? "" : "\n");
        }

        $this->writeComments($node->getComments());
        $this->writePropertiesMultiLine($node->getProperties());

        return true;
    }

    public function handleLeave(Node $node): void
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

    protected function writePropertiesMultiLine(Properties $properties): void
    {
        foreach ($properties as $property) {
            $this->write($this->indent(), "@", $property->getName(), "(", json_encode($property->getValue()), ")\n");
        }
    }

    protected function writePropertiesSingleLine(Properties $properties): void
    {
        foreach ($properties as $property) {
            $this->write("@", $property->getName(), "(", json_encode($property->getValue()), ") ");
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
