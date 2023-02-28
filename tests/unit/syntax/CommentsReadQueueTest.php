<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron\ast;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\ast\CommentsReadQueue
 * @uses   \lengo\avron\ast\Comment
 */
class CommentsReadQueueTest extends TestCase
{
    public function testQueue()
    {
        $c0 = $this->createMock(Comment::class);
        $c1 = $this->createMock(Comment::class);

        $queue = new CommentsReadQueue();
        $this->assertSame(0, $queue->size());

        $queue->enqueue($c0);
        $queue->enqueue($c1);
        $this->assertSame(2, $queue->size());

        $comments = $queue->drain();
        $this->assertSame(0, $queue->size());

        $this->assertSame($c0, $comments[0]);
        $this->assertSame($c1, $comments[1]);
    }
}
