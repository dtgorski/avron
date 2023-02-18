<?php declare(strict_types=1);

// MIT License · Daniel T. Gorski <dtg [at] lengo [dot] org> · 02/2023

namespace lengo\avron;

use PHPUnit\Framework\TestCase;

/**
 * @covers \lengo\avron\BufferedWriter
 */
class BufferedWriterTest extends TestCase
{
    public function testWrite(): void
    {
        $writer = new BufferedWriter();

        $writer->write("foo\n");
        $writer->write("bar\n");
        $this->assertEquals("foo\nbar\n", $writer->getBuffer());

        $writer->clearBuffer();
        $this->assertEquals("", $writer->getBuffer());
    }
}
