<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\DeclarationNode
 * @uses   \lengo\avron\ast\Comment
 * @uses   \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\Node
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
}
