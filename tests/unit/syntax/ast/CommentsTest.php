<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\AST;

use PHPUnit\Framework\TestCase;

/**
 * @covers \Avron\AST\Comments
 * @uses   \Avron\AST\Comment
 */
class CommentsTest extends TestCase
{
    public function testComments()
    {
        $comment1 = new Comment("foo");
        $comment2 = new Comment("bar");

        $comments = Comments::fromArray([$comment1, $comment2]);

        $this->assertSame(2, $comments->size());
        $this->assertEquals([$comment1, $comment2], $comments->asArray());
        $this->assertSame($comment1, $comments->getIterator()->current());
    }
}
