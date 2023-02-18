<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\AvroException
 */
class AvroExceptionTest extends TestCase
{
    public function testGetError(): void
    {
        $e = new AvroException("foo");
        $this->assertSame("avro exception: foo", $e->getError());
    }
}
