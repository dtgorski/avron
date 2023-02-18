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
    public function testAddRetrieve(): void
    {
        $c0 = $this->createMock(Comment::class);
        $c1 = $this->createMock(Comment::class);
        $c2 = $this->createMock(Comment::class);

        $comments = new Comments([$c0, $c1]);
        $this->assertSame(2, $comments->size());

        $comments->add($c2);
        $this->assertSame(3, $comments->size());

        $test = function (Comment $comment, int $i) use ($c0, $c1, $c2): void {
            $expect = [$c0, $c1, $c2];
            $this->assertSame($expect[$i], $comment);
        };

        $i = 0;
        foreach ($comments as $comment) {
            $test($comment, $i++);
        }
    }
}
