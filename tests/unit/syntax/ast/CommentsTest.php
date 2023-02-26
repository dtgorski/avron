<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\Comments
 * @uses   \lengo\avron\ast\Comment
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
    }
}
