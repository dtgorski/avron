<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use lengo\avron\api\SourceFile;
use lengo\avron\core\NodeNamespace;
use lengo\avron\core\RealPath;
use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\api\SourceFile
 * @uses   \lengo\avron\ast\Comment
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\Node
 * @uses   \lengo\avron\core\NodeNamespace
 */
class DeclarationNodeTest extends TestCase
{
    public function testAddGetComments(): void
    {
        $node = new class extends DeclarationNode {
        };

        $this->assertSame(0, $node->getComments()->size());
        $node->setComments(new Comments([new Comment("foo"), new Comment("bar")]));
        $this->assertSame(2, $node->getComments()->size());

        $i = 0;
        foreach ($node->getComments() as $comment) {
            if ($i == 0) {
                $this->assertEquals("foo", $comment->getText());
            }
            if ($i == 1) {
                $this->assertEquals("bar", $comment->getText());
            }
            $i++;
        }
    }

    public function testSetGetNamespace(): void
    {
        $node = new class extends DeclarationNode {
        };
        $this->assertNull($node->getNamespace());

        $namespace = $this->createMock(NodeNamespace::class);
        $this->assertSame($namespace, $node->setNamespace($namespace)->getNamespace());
    }

    public function testSetGetSourceFile(): void
    {
        $node = new class extends DeclarationNode {
        };
        $this->assertNull($node->getSourceFile());

        $sourceFile = $this->createMock(SourceFile::class);
        $this->assertSame($sourceFile, $node->setSourceFile($sourceFile)->getSourceFile());
    }
}
