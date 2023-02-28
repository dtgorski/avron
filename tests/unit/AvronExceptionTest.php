<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 03/2023

namespace lengo\avron;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\AvronException
 */
class AvronExceptionTest extends TestCase
{
    public function testGetError(): void
    {
        $e = new AvronException("foo");
        $this->assertSame("avron error: foo", $e->getError());
    }
}
