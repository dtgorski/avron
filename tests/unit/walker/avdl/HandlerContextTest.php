<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace Avron\Idl;

use Avron\StandardWriter;
use PHPUnit\Framework\TestCase;
use RuntimeException;

/**
 * @covers \Avron\Idl\HandlerContext
 */
class HandlerContextTest extends TestCase
{
    public function testGetWriter(): void
    {
        $writer = $this->createMock(StandardWriter::class);
        $ctx = new HandlerContext($writer);

        $this->assertSame($writer, $ctx->getWriter());
    }

    public function testStepInStepPutIndent(): void
    {
        $writer = $this->createMock(StandardWriter::class);
        $ctx = new HandlerContext($writer);

        $this->assertSame(0, $ctx->getStep());
        $ctx->stepIn();
        $ctx->stepIn();
        $this->assertSame(2, $ctx->getStep());
        $ctx->stepOut();
        $this->assertSame(1, $ctx->getStep());
    }

    public function testThrowsExceptionOnUnderrun(): void
    {
        $writer = $this->createMock(StandardWriter::class);
        $ctx = new HandlerContext($writer);

        $this->expectException(RuntimeException::class);
        $ctx->stepOut();
    }
}
