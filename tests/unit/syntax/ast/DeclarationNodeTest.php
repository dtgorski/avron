<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Ast;

use Avron\Api\SourceFile;
use Avron\Core\NodeNamespace;
use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\Ast\DeclarationNode
 * @uses   \Avron\Api\SourceFile
 * @uses   \Avron\Ast\Comment
 * @uses   \Avron\Ast\Comments
 * @uses   \Avron\Ast\AstNode
 * @uses   \Avron\Ast\Properties
 * @uses   \Avron\Core\ArrayList
 * @uses   \Avron\Core\NodeNamespace
 * @uses   \Avron\Core\TreeNode
 */
class DeclarationNodeTest extends TestCase
{
    public function testAddGetComments(): void
    {
        $node = new class extends DeclarationNode {
        };

        $this->assertSame(0, $node->getComments()->size());
        $node->setComments(Comments::fromArray([new Comment("foo"), new Comment("bar")]));
        $this->assertSame(2, $node->getComments()->size());

        $test = function (Comment $comment, int $i): void {
            $expect = ["foo", "bar"];
            $this->assertEquals($expect[$i], $comment->getText());
        };

        $i = 0;
        foreach ($node->getComments() as $comment) {
            $test($comment, $i++);
        }
    }

    public function testSetGetNamespace(): void
    {
        $node = new class extends DeclarationNode {
        };
        $this->assertNull($node->getNamespace());

        $namespace = $this->createMock(NodeNamespace::class);
        $node->setNamespace($namespace);
        $this->assertSame($namespace, $node->getNamespace());
    }

    public function testSetGetSourceFile(): void
    {
        $node = new class extends DeclarationNode {
        };
        $this->assertNull($node->getSourceFile());

        $sourceFile = $this->createMock(SourceFile::class);
        $node->setSourceFile($sourceFile);
        $this->assertSame($sourceFile, $node->getSourceFile());
    }
}
